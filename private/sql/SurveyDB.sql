USE KiKiPups
GO

--	CREATE SCHEMA SurveyDB
--	GO

--	===========================================================
--		Drop Object
--	===========================================================
IF OBJECT_ID('SurveyDB.UserResponse') IS NOT NULL DROP TABLE SurveyDB.UserResponse;
IF OBJECT_ID('SurveyDB.UserTemplate') IS NOT NULL DROP TABLE SurveyDB.UserTemplate;

IF OBJECT_ID('SurveyDB.RuleValue') IS NOT NULL DROP TABLE SurveyDB.RuleValue;
IF OBJECT_ID('SurveyDB.Rule') IS NOT NULL DROP TABLE SurveyDB.[Rule];

IF OBJECT_ID('SurveyDB.Item') IS NOT NULL DROP TABLE SurveyDB.Item;
IF OBJECT_ID('SurveyDB.Element') IS NOT NULL DROP TABLE SurveyDB.Element;
IF OBJECT_ID('SurveyDB.Section') IS NOT NULL DROP TABLE SurveyDB.Section;
IF OBJECT_ID('SurveyDB.Template') IS NOT NULL DROP TABLE SurveyDB.Template;

IF OBJECT_ID('SurveyDB.TemplateType') IS NOT NULL DROP TABLE SurveyDB.TemplateType;
IF OBJECT_ID('SurveyDB.ElementType') IS NOT NULL DROP TABLE SurveyDB.ElementType;
IF OBJECT_ID('SurveyDB.ActionType') IS NOT NULL DROP TABLE SurveyDB.ActionType;
IF OBJECT_ID('SurveyDB.ValueType') IS NOT NULL DROP TABLE SurveyDB.ValueType;
IF OBJECT_ID('SurveyDB.OperatorType') IS NOT NULL DROP TABLE SurveyDB.OperatorType;
GO


--	===========================================================
--		Dictionary Tables
--	===========================================================
CREATE TABLE SurveyDB.TemplateType (
	TemplateTypeID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	Name VARCHAR(255) NOT NULL UNIQUE,
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);
INSERT INTO SurveyDB.TemplateType (Name)
VALUES
	('Standard'),
	('Branching');


CREATE TABLE SurveyDB.ElementType (
	ElementTypeID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	Name VARCHAR(255) NOT NULL UNIQUE,
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);
INSERT INTO SurveyDB.ElementType (Name)
VALUES
	('Weighted'),
	('Points'),
	('Value'),
	('Input');


CREATE TABLE SurveyDB.ActionType (
	ActionTypeID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	Name VARCHAR(255) NOT NULL UNIQUE,
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);
INSERT INTO SurveyDB.ActionType (Name)
VALUES
	('GAIN'),
	('LOSE'),
	('GOTO'),
	('ENTRY'),
	('INQUIRY'),
	('SHOW'),
	('HIDE');


CREATE TABLE SurveyDB.ValueType (
	ValueTypeID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	Name VARCHAR(255) NOT NULL UNIQUE,
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);
INSERT INTO SurveyDB.ValueType (Name)
VALUES
	('Standard'),
	('DataSource');

	
CREATE TABLE SurveyDB.OperatorType (
	OperatorTypeID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,

	Name VARCHAR(255) NOT NULL UNIQUE,
	Label VARCHAR(255) NULL,
	[Description] NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);
INSERT INTO SurveyDB.OperatorType (Name, Label)
VALUES
	('EQUALS', '='),
	('IN', 'In'),
	('GREATER_THAN', '>'),
	('GREATER_THAN_EQUAL', '>='),
	('LESS_THAN', '<'),
	('LESS_THAN_EQUAL', '<='),
	('BETWEEN', 'Between');


--	===========================================================
--		Content Tables
--	===========================================================
CREATE TABLE SurveyDB.Template (
	TemplateID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	TemplateTypeID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.TemplateType (TemplateTypeID),

	Name VARCHAR(255) NOT NULL,
	Content NVARCHAR(MAX) NULL,	-- Description, Comments, Instructions, etc.
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

CREATE TABLE SurveyDB.Section (
	SectionID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	TemplateID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.Template (TemplateID),

	Content NVARCHAR(MAX) NULL,	-- Description, Comments, Instructions, etc.
	Ordinality INT NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

CREATE TABLE SurveyDB.Element (
	ElementID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	SectionID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.Section (SectionID),
	ElementTypeID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.ElementType (ElementTypeID),

	Content NVARCHAR(MAX) NOT NULL,	-- The Element text
	NumberOfItems INT NOT NULL DEFAULT 1,
	Ordinality INT NULL,
	IsMandatory BIT NOT NULL DEFAULT 0,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

CREATE TABLE SurveyDB.Item (
	ItemID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	ElementID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.Element (ElementID),

	Content NVARCHAR(MAX) NOT NULL,	-- The Item text
	Value VARCHAR(255) NOT NULL,

	Ordinality INT NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);


CREATE TABLE SurveyDB.[Rule] (
	RuleID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	ElementID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.Element (ElementID),
	
	OperatorTypeID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.OperatorType (OperatorTypeID),
	ValueTypeID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.ValueType (ValueTypeID),
	ActionTypeID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.ActionType (ActionTypeID),
	IsNegatedCondition BIT NOT NULL DEFAULT 0,	-- e.g. X = Y vs !(X = Y)
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);


CREATE TABLE SurveyDB.RuleValue (
	RuleValueID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	RuleID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.[Rule] (RuleID),
	
	Value NVARCHAR(MAX) NOT NULL,
	Ordinality INT NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);


CREATE TABLE SurveyDB.UserTemplate (
	UserTemplateID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	
	UserID INT NOT NULL FOREIGN KEY REFERENCES UserDB.[User] (UserID),
	TemplateID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.[Template] (TemplateID),
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);

CREATE TABLE SurveyDB.UserResponse (
	UserResponseID INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	
	UserTemplateID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.[UserTemplate] (UserTemplateID),
	ElementID INT NOT NULL FOREIGN KEY REFERENCES SurveyDB.[Element] (ElementID),
	Value NVARCHAR(MAX) NULL,
	
	UUID UNIQUEIDENTIFIER NOT NULL DEFAULT NEWID(),
	CreatedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	ModifiedDateTimeUTC DATETIME2(3) NOT NULL DEFAULT SYSUTCDATETIME(),
	DeactivatedDateTimeUTC DATETIME2(3) NULL
);