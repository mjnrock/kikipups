USE KiKiPups
GO

--	CREATE SCHEMA ProfileDB
--	GO

--	===========================================================
--		Drop Object
--	===========================================================
IF OBJECT_ID('ProfileDB.AnimalType') IS NOT NULL DROP TABLE ProfileDB.AnimalType;
GO


--	===========================================================
--		Dictionary Tables
--	===========================================================
CREATE TABLE ProfileDB.AnimalType (
	AnimalTypeID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	Name VARCHAR(255) NOT NULL UNIQUE,
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);
INSERT INTO ProfileDB.AnimalType (Name)
VALUES
	('Human'),
	('Cat'),
	('Dog');