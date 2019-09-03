USE KiKiPups
GO

--	CREATE SCHEMA PlatformDB
--	GO

--	==================================================
--		NOTES
--	==================================================
--		CODE: XPL
--	* The "Group" is the meaningful unit in this design
--		for access control, and the "User" is just a singular
--		mapping account to a group (e.g. An account holder)
--	==================================================

IF OBJECT_ID('PlatformDB.GroupMember') IS NOT NULL DROP TABLE PlatformDB.GroupMember;
IF OBJECT_ID('PlatformDB.UserDetail') IS NOT NULL DROP TABLE PlatformDB.UserDetail;

IF OBJECT_ID('PlatformDB.MessagePost') IS NOT NULL DROP TABLE PlatformDB.[MessagePost];
IF OBJECT_ID('PlatformDB.MessageThread') IS NOT NULL DROP TABLE PlatformDB.MessageThread;

IF OBJECT_ID('PlatformDB.Group') IS NOT NULL DROP TABLE PlatformDB.[Group];
IF OBJECT_ID('PlatformDB.User') IS NOT NULL DROP TABLE PlatformDB.[User];

IF OBJECT_ID('PlatformDB.GroupMemberType') IS NOT NULL DROP TABLE PlatformDB.GroupMemberType;
IF OBJECT_ID('PlatformDB.GroupType') IS NOT NULL DROP TABLE PlatformDB.GroupType;
IF OBJECT_ID('PlatformDB.AccountType') IS NOT NULL DROP TABLE PlatformDB.AccountType;

IF OBJECT_ID('PlatformDB.BitMaskFlag') IS NOT NULL DROP TABLE PlatformDB.BitMaskFlag;
IF OBJECT_ID('PlatformDB.BitMask') IS NOT NULL DROP TABLE PlatformDB.BitMask;

IF OBJECT_ID('PlatformDB.DictionaryEntry') IS NOT NULL DROP TABLE PlatformDB.DictionaryEntry;
IF OBJECT_ID('PlatformDB.Dictionary') IS NOT NULL DROP TABLE PlatformDB.Dictionary;
GO

CREATE TABLE PlatformDB.Dictionary (
	DictionaryID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	ParentDictionaryID INT NULL FOREIGN KEY REFERENCES PlatformDB.[Dictionary] (DictionaryID),	-- Use as a reference for versioning
	
	Code VARCHAR(255) NOT NULL UNIQUE,
	Name VARCHAR(255) NOT NULL,
	[Description] NVARCHAR(MAX) NULL,
	[Version] REAL NULL,
	
	IsActive BIT NOT NULL DEFAULT 1,
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);

CREATE TABLE PlatformDB.DictionaryEntry (
	DictionaryEntryID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	DictionaryID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.[Dictionary] (DictionaryID),
	
	Name VARCHAR(255) NOT NULL,
	Label VARCHAR(255) NULL,
	Value VARCHAR(MAX) NOT NULL,
	[Description] NVARCHAR(MAX) NULL,
	Ordinality INT NULL,
	
	IsActive BIT NOT NULL DEFAULT 1,
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);

CREATE TABLE PlatformDB.BitMask (
	BitMaskID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,

	Name VARCHAR(255) NOT NULL,
	[Description] NVARCHAR(MAX) NULL,

	IsActive BIT NOT NULL DEFAULT 1,
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);
CREATE TABLE PlatformDB.BitMaskFlag (
	BitMaskFlagID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	BitMaskID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.BitMask (BitMaskID),

	Flag INT NOT NULL,
	Name VARCHAR(255) NOT NULL,
	Label VARCHAR(255) NOT NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	IsActive BIT NOT NULL DEFAULT 1,
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);

CREATE TABLE PlatformDB.AccountType (
	AccountTypeID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,

	Code VARCHAR(255) NOT NULL UNIQUE,
	Name VARCHAR(255) NOT NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	IsActive BIT NOT NULL DEFAULT 1,
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);
INSERT INTO PlatformDB.AccountType (Code, Name, [Description])
VALUES
	('NATIVE', 'Native', 'A Native Account on the Platform'),
	('OAUTH', 'OAuth', NULL),
	('GOOGLE', 'Google', NULL),
	('FACEBOOK', 'Facebook', NULL);

CREATE TABLE PlatformDB.GroupType (
	GroupTypeID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,

	Code VARCHAR(255) NOT NULL UNIQUE,
	Name VARCHAR(255) NOT NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	IsActive BIT NOT NULL DEFAULT 1,
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);
INSERT INTO PlatformDB.GroupType (Code, Name, [Description])
VALUES
	('PLATFORM', 'Platform', 'A "root" group for all Platform-level actions'),
	('MULTIAUTH', 'Multiple Authentication', 'A group to connect multiple User accounts to functionally treat as one (1) User (e.g. "Multiboxing")'),
	('PROFILE', 'Profile', 'A group for Profiles'),
	('CHAT', 'CHAT', 'A group for Chat'),
	('FAMILY', 'Family', 'A connected Family unit of Users'),
	('BUSINESS', 'Business', 'A Business-owned group of Users'),
	('EVENT', 'Event', 'A group for Events'),
	('SOCIAL', 'Social', 'A group for Social connections'),
	('DATING', 'Dating', 'A group for Dating connections'),
	('BREEDING', 'Breeding', 'A group for Breeding connections'),
	('ADOPTION', 'Adoption', 'A group for Adoptions'),
	('MARKETPLACE', 'Marketplace', 'A group buying and selling goods and services'),
	('EXCHANGE', 'Exchange', 'A group exchanging goods and services'),
	('EDUCATION', 'Education', 'A group education-related endeavors'),
	('HEALTH', 'Health', 'A group for Health and health-related things'),
	('ALERT', 'Alert', 'A group for alerting (e.g. Lost Pet)');

CREATE TABLE PlatformDB.GroupMemberType (
	GroupMemberTypeID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	GroupTypeID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.GroupType (GroupTypeID),

	Code VARCHAR(255) NOT NULL UNIQUE,
	Name VARCHAR(255) NOT NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	IsActive BIT NOT NULL DEFAULT 1,
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);
DECLARE @GroupTypeID_PLATFORM INT = (SELECT GroupTypeID FROM PlatformDB.GroupType gt WHERE gt.Code = 'PLATFORM');
INSERT INTO PlatformDB.GroupMemberType (GroupTypeID, Code, Name, [Description])
VALUES
	(@GroupTypeID_PLATFORM, 'PRIMARY', 'Primary', 'The creator or primary owner of the group and with ALL privileges'),
	(@GroupTypeID_PLATFORM, 'ADMIN', 'Admin', 'A user with FULL privileges, except certain gated actions'),
	(@GroupTypeID_PLATFORM, 'ADULT', 'Adult', 'A full-view READ/WRITE user'),
	(@GroupTypeID_PLATFORM, 'MINOR', 'Minor', 'A adult-content-filtered READ/WRITE user');

CREATE TABLE PlatformDB.[User] (
	UserID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	AccountTypeID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.AccountType (AccountTypeID),

	Username VARCHAR(255) NOT NULL,
	[Password] VARCHAR(255) NULL,
	Salt VARCHAR(255) NULL DEFAULT NEWID(),

	LoginDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	FailedAttemps INT NULL DEFAULT 0,
	FailedIPAddress VARCHAR(255) NULL,
	
	CreatedIPAddress VARCHAR(255) NOT NULL,
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),

	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);

CREATE TABLE PlatformDB.UserDetail (
	UserDetailID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	UserID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.[User] (UserID),
	
	FirstName VARCHAR(255) NULL,
	MiddleName VARCHAR(255) NULL,
	LastName VARCHAR(255) NULL,

	Email VARCHAR(255) NULL,
	Phone1 VARCHAR(255) NULL,
	Phone2 VARCHAR(255) NULL,
	
	Address1 VARCHAR(255) NULL,
	Address2 VARCHAR(255) NULL,
	City VARCHAR(255) NULL,
	County VARCHAR(255) NULL,
	[State] VARCHAR(255) NULL,
	Zip5 VARCHAR(255) NULL,

	DateOfBirth DATE NULL,

	IsMinor AS CASE
		WHEN DATEDIFF(YEAR, DateOfBirth, SYSUTCDATETIME()) >= 18 THEN 0
		ELSE 1
	END,
	
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

CREATE TABLE PlatformDB.[Group] (
	GroupID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	GroupTypeID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.GroupType (GroupTypeID),	-- Here as a connection constraint for GroupMemberTypeID in GroupMember JOINs

	Name NVARCHAR(255) NOT NULL,
	[Description] NVARCHAR(MAX) NULL,

	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL,

	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);

CREATE TABLE PlatformDB.GroupMember (
	GroupMemberID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	
	UserID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.[User] (UserID),
	GroupID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.[Group] (GroupID),
	GroupMemberTypeID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.GroupMemberType (GroupMemberTypeID),

	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL,

	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);


--	Creating a new MessageThread should involve creating a new CHAT type Group and adding the appropriate Group members with permissions
CREATE TABLE PlatformDB.MessageThread (
	MessageThreadID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	
	Title NVARCHAR(255) NOT NULL,
	[Description] NVARCHAR(MAX) NOT NULL,

	ChatGroupID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.[Group] (GroupID),	-- Creating a MessageThread should create designated CHAT Group for permissions
	
	CreatedByUserID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.[User] (UserID),
	CreatedByGroupID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.[Group] (GroupID),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),

	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL,

	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);

CREATE TABLE PlatformDB.MessagePost (
	MessagePostID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	MessageThreadID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.MessageThread (MessageThreadID),

	Content NVARCHAR(MAX) NOT NULL,
	ParentMessagePostID INT NULL FOREIGN KEY REFERENCES PlatformDB.MessagePost (MessagePostID),

	CreatedByUserID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.[User] (UserID),
	CreatedByGroupID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.[Group] (GroupID),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),

	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL,

	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);