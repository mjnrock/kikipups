USE KiKiPups
GO

--	CREATE SCHEMA PlatformDB
--	GO

IF OBJECT_ID('PlatformDB.GroupMember') IS NOT NULL DROP TABLE PlatformDB.GroupMember;
IF OBJECT_ID('PlatformDB.UserDetail') IS NOT NULL DROP TABLE PlatformDB.UserDetail;

--IF OBJECT_ID('PlatformDB.MessagePost') IS NOT NULL DROP TABLE PlatformDB.[MessagePost];
--IF OBJECT_ID('PlatformDB.MessageThread') IS NOT NULL DROP TABLE PlatformDB.MessageThread;

IF OBJECT_ID('PlatformDB.Group') IS NOT NULL DROP TABLE PlatformDB.[Group];
IF OBJECT_ID('PlatformDB.User') IS NOT NULL DROP TABLE PlatformDB.[User];

IF OBJECT_ID('PlatformDB.GroupMemberType') IS NOT NULL DROP TABLE PlatformDB.GroupMemberType;
IF OBJECT_ID('PlatformDB.GroupType') IS NOT NULL DROP TABLE PlatformDB.GroupType;
IF OBJECT_ID('PlatformDB.AccountType') IS NOT NULL DROP TABLE PlatformDB.AccountType;

IF OBJECT_ID('PlatformDB.BitMaskFlag') IS NOT NULL DROP TABLE PlatformDB.BitMaskFlag;
IF OBJECT_ID('PlatformDB.BitMask') IS NOT NULL DROP TABLE PlatformDB.BitMask;

IF OBJECT_ID('PlatformDB.DictionaryEntry') IS NOT NULL DROP TABLE PlatformDB.DictionaryEntry;
IF OBJECT_ID('PlatformDB.Dictionary') IS NOT NULL DROP TABLE PlatformDB.Dictionary;