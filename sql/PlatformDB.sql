USE KiKiPups
GO

--	CREATE SCHEMA PlatformDB
--	GO

IF OBJECT_ID('PlatformDB.BitMaskFlag') IS NOT NULL DROP TABLE PlatformDB.BitMaskFlag;
IF OBJECT_ID('PlatformDB.BitMask') IS NOT NULL DROP TABLE PlatformDB.BitMask;

IF OBJECT_ID('PlatformDB.DictionaryEntry') IS NOT NULL DROP TABLE PlatformDB.DictionaryEntry;
IF OBJECT_ID('PlatformDB.Dictionary') IS NOT NULL DROP TABLE PlatformDB.Dictionary;

IF OBJECT_ID('PlatformDB.DataType') IS NOT NULL DROP TABLE PlatformDB.DataType;
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
	ParentDictionaryEntryID INT NOT NULL FOREIGN KEY REFERENCES PlatformDB.DictionaryEntry (DictionaryEntryID),
	
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

CREATE TABLE PlatformDB.DataType (
	DataTypeID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	Name VARCHAR(255) NOT NULL UNIQUE,
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	ParentDataTypeID INT NULL FOREIGN KEY REFERENCES PlatformDB.DataType (DataTypeID),	-- For Primitive:Complex type breakdowns
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);
INSERT INTO PlatformDB.DataType (Name)
VALUES
	('Character'),
	('String'),
	('Int8'),
	('Int16'),
	('Int32'),
	('Int64'),
	('Float'),
	('Real'),
	('Boolean'),
	('Array'),
	('Object'),
	('UUID'),
	('URI'),
	('Image'),
	('Video');