USE KiKiPups
GO

--	CREATE SCHEMA UserDB
--	GO

IF OBJECT_ID('UserDB.GroupMember') IS NOT NULL DROP TABLE UserDB.GroupMember;
IF OBJECT_ID('UserDB.UserDetail') IS NOT NULL DROP TABLE UserDB.UserDetail;

IF OBJECT_ID('UserDB.Group') IS NOT NULL DROP TABLE UserDB.[Group];
IF OBJECT_ID('UserDB.User') IS NOT NULL DROP TABLE UserDB.[User];

IF OBJECT_ID('UserDB.RoleType') IS NOT NULL DROP TABLE UserDB.RoleType;
IF OBJECT_ID('UserDB.GroupType') IS NOT NULL DROP TABLE UserDB.GroupType;
IF OBJECT_ID('UserDB.AccountType') IS NOT NULL DROP TABLE UserDB.AccountType;
GO


CREATE TABLE UserDB.AccountType (
	AccountTypeID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,

	Code VARCHAR(255) NOT NULL UNIQUE,
	Name VARCHAR(255) NOT NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	IsActive BIT NOT NULL DEFAULT 1,
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);
INSERT INTO UserDB.AccountType (Code, Name, [Description])
VALUES
	('NATIVE', 'Native', 'A Native Account on the Platform'),
	('OAUTH', 'OAuth', NULL),
	('GOOGLE', 'Google', NULL),
	('FACEBOOK', 'Facebook', NULL);

CREATE TABLE UserDB.GroupType (
	GroupTypeID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,

	Code VARCHAR(255) NOT NULL UNIQUE,
	Name VARCHAR(255) NOT NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	IsActive BIT NOT NULL DEFAULT 1,
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);
INSERT INTO UserDB.GroupType (Code, Name, [Description])
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

CREATE TABLE UserDB.RoleType (
	RoleTypeID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	GroupTypeID INT NOT NULL FOREIGN KEY REFERENCES UserDB.GroupType (GroupTypeID),

	Code VARCHAR(255) NOT NULL UNIQUE,
	Name VARCHAR(255) NOT NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	IsActive BIT NOT NULL DEFAULT 1,
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);
DECLARE @GroupTypeID_PLATFORM INT = (SELECT GroupTypeID FROM UserDB.GroupType gt WHERE gt.Code = 'PLATFORM');
INSERT INTO UserDB.RoleType (GroupTypeID, Code, Name, [Description])
VALUES
	(@GroupTypeID_PLATFORM, 'PRIMARY', 'Primary', 'The creator or primary owner of the group and with ALL privileges'),
	(@GroupTypeID_PLATFORM, 'ADMIN', 'Admin', 'A user with FULL privileges, except certain gated actions'),
	(@GroupTypeID_PLATFORM, 'ADULT', 'Adult', 'A full-view READ/WRITE user'),
	(@GroupTypeID_PLATFORM, 'MINOR', 'Minor', 'A adult-content-filtered READ/WRITE user');

CREATE TABLE UserDB.[User] (
	UserID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	AccountTypeID INT NOT NULL FOREIGN KEY REFERENCES UserDB.AccountType (AccountTypeID),

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

CREATE TABLE UserDB.UserDetail (
	UserDetailID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	UserID INT NOT NULL FOREIGN KEY REFERENCES UserDB.[User] (UserID),
	
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

CREATE TABLE UserDB.[Group] (
	GroupID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	GroupTypeID INT NOT NULL FOREIGN KEY REFERENCES UserDB.GroupType (GroupTypeID),	-- Here as a connection constraint for RoleTypeID in GroupMember JOINs

	Name NVARCHAR(255) NOT NULL,
	[Description] NVARCHAR(MAX) NULL,

	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL,

	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);

CREATE TABLE UserDB.GroupMember (
	GroupMemberID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	
	GroupID INT NOT NULL FOREIGN KEY REFERENCES UserDB.[Group] (GroupID),
	UserID INT NOT NULL FOREIGN KEY REFERENCES UserDB.[User] (UserID),
	RoleTypeID INT NOT NULL FOREIGN KEY REFERENCES UserDB.RoleType (RoleTypeID),

	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL,

	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID()
);