USE KiKiPups
GO

--	CREATE SCHEMA SocialDB
--	GO

--	===========================================================
--		Drop Object
--	===========================================================
IF OBJECT_ID('SocialDB.Feed') IS NOT NULL DROP TABLE SocialDB.Feed;

IF OBJECT_ID('SocialDB.DataGroupDataItem') IS NOT NULL DROP TABLE SocialDB.DataGroupDataItem;
IF OBJECT_ID('SocialDB.AnimalDataGroup') IS NOT NULL DROP TABLE SocialDB.AnimalDataGroup;
IF OBJECT_ID('SocialDB.Relationship') IS NOT NULL DROP TABLE SocialDB.Relationship;
IF OBJECT_ID('SocialDB.Subscription') IS NOT NULL DROP TABLE SocialDB.Subscription;

IF OBJECT_ID('SocialDB.DataItem') IS NOT NULL DROP TABLE SocialDB.DataItem;
IF OBJECT_ID('SocialDB.DataGroup') IS NOT NULL DROP TABLE SocialDB.[DataGroup];

IF OBJECT_ID('SocialDB.PostReaction') IS NOT NULL DROP TABLE SocialDB.PostReaction;
IF OBJECT_ID('SocialDB.Post') IS NOT NULL DROP TABLE SocialDB.Post;
IF OBJECT_ID('SocialDB.Animal') IS NOT NULL DROP TABLE SocialDB.Animal;

IF OBJECT_ID('SocialDB.AnimalType') IS NOT NULL DROP TABLE SocialDB.AnimalType;
IF OBJECT_ID('SocialDB.RelationshipType') IS NOT NULL DROP TABLE SocialDB.RelationshipType;
IF OBJECT_ID('SocialDB.PostType') IS NOT NULL DROP TABLE SocialDB.PostType;
IF OBJECT_ID('SocialDB.ContentType') IS NOT NULL DROP TABLE SocialDB.ContentType;
GO


--	===========================================================
--		Dictionary Tables
--	===========================================================
CREATE TABLE SocialDB.AnimalType (
	AnimalTypeID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	Name VARCHAR(255) NOT NULL UNIQUE,
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);
INSERT INTO SocialDB.AnimalType (Name)
VALUES
	('Human'),
	('Cat'),
	('Dog');


CREATE TABLE SocialDB.RelationshipType (
	RelationshipTypeID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	Name VARCHAR(255) NOT NULL UNIQUE,
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);
INSERT INTO SocialDB.RelationshipType (Name)
VALUES
	('Family'),
	('Friend'),
	('Romantic'),
	('Business');


CREATE TABLE SocialDB.PostType (
	PostTypeID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	Name VARCHAR(255) NOT NULL UNIQUE,
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);
INSERT INTO SocialDB.PostType (Name)
VALUES
	('Comment'),
	('Lesson'),
	('Education'),
	('Question'),
	('Poll'),
	('Survey'),
	('Gained'),
	('Lost'),
	('Quote'),
	('Mood'),
	('Alert'),
	('Health'),
	('Buy'),
	('Sell');


CREATE TABLE SocialDB.ContentType (
	ContentTypeID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	Name VARCHAR(255) NOT NULL UNIQUE,
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);
INSERT INTO SocialDB.ContentType (Name)
VALUES
	('Mixed'),	-- Application logic could be present
	('Text'),
	('Image'),
	('Video'),
	('Poll'),
	('Survey'),
	('Graph');
	

--	===========================================================
--		Content Tables
--	===========================================================
CREATE TABLE SocialDB.Animal (
	AnimalID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	AnimalTypeID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.AnimalType (AnimalTypeID),
	UserID INT NOT NULL FOREIGN KEY REFERENCES UserDB.[User] (UserID),
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

--	How does Animal A relate to Animal B (e.g. Brother, Friend, Spouse, etc.)
CREATE TABLE SocialDB.Relationship (
	RelationshipID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	AnimalFromID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.Animal (AnimalID),
	AnimalToID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.Animal (AnimalID),
	RelationshipTypeID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.RelationshipType (RelationshipTypeID),
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

--	Animal A subscribes/follows Animal B -- From A:To B
CREATE TABLE SocialDB.Subscription (
	SubscriptionID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	AnimalFromID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.Animal (AnimalID),
	AnimalToID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.Animal (AnimalID),
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

CREATE TABLE SocialDB.Post (
	PostID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	AnimalID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.Animal (AnimalID),	
	PostTypeID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.PostType (PostTypeID),
	ContentTypeID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.ContentType (ContentTypeID),
	Content NVARCHAR(MAX) NOT NULL,
	ParentPostID INT NULL FOREIGN KEY REFERENCES SocialDB.Post (PostID),	-- Allow for nested posts
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

--	Allow for a Discord-like Emoji reaction to a post, instead of just Like/Dislike/etc.
CREATE TABLE SocialDB.PostReaction (
	PostReactionID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	PostID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.Post (PostID),
	AnimalID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.Animal (AnimalID),
	Content NCHAR(1) NOT NULL,	-- Expects an Emoji
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

--	Create a home for a Post within any Group, though not necessary for a Post, just creates a Telegram-like message style
CREATE TABLE SocialDB.Feed (
	FeedID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	
	PostID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.Post (PostID),
	GroupID INT NOT NULL FOREIGN KEY REFERENCES UserDB.[Group] (GroupID),
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);


--	A SurveyDB.Element with type enforcement
CREATE TABLE SocialDB.DataItem (
	DataItemID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	
	SurveyElementID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.Element (ElementID),
	DataTypeID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.DataType (DataTypeID),
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

--	A SurveyDB.Template that is being used as a data feed
CREATE TABLE SocialDB.[DataGroup] (
	DataGroupID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	
	SurveyTemplateID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.Template (TemplateID),
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

--	Assigning a (sub)set of the original Template's Elements to the data feed (i.e. allow for Element cherry-picking)
CREATE TABLE SocialDB.DataGroupDataItem (
	DataGroupDataItemID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	
	DataGroupID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.[DataGroup] (DataGroupID),
	DataItemID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.DataItem (DataItemID),
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

--	Associate User and Animal SurveyDB.Template responses to a given DataGroup archetype (i.e. instantiate a DataGroup)
CREATE TABLE SocialDB.AnimalDataGroup (
	AnimalDataGroupID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	
	AnimalID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.Animal (AnimalID),
	DataGroupID INT NOT NULL FOREIGN KEY REFERENCES SocialDB.[DataGroup] (DataGroupID),
	SurveyUserTemplateID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.UserTemplate (UserTemplateID),
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);