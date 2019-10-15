USE KiKiPups
GO


IF OBJECT_ID('GetData') IS NOT NULL DROP FUNCTION GetData;
GO

CREATE FUNCTION GetData
(	
	@Input VARCHAR(255),
	@Flag INT = 0
)
RETURNS TABLE 
AS
RETURN 
(
	SELECT
		*
	FROM
		Data d WITH (NOLOCK)
	WHERE
		(
			@Flag = 0
			AND @Input = CAST(d.Name AS VARCHAR(255))
		)
		OR
		(
			@Flag = 1
			AND @Input = CAST(d.DataID AS VARCHAR(255))
		)
		OR
		(
			@Flag = 2
			AND @Input = CAST(d.UUID AS VARCHAR(255))
		)
)
GO


IF OBJECT_ID('GetCoreDictionaries') IS NOT NULL DROP FUNCTION GetCoreDictionaries;
GO

CREATE FUNCTION GetCoreDictionaries
()
RETURNS TABLE 
AS
RETURN 
(
	SELECT
		d.DictionaryID AS dDictionaryID,
		d.Name AS dName,
		d.Label AS dLabel,
		d.[Description] AS dDescription,
		d.[Version] AS dVersion,
		d.ParentDictionaryID AS dParentDictionaryID,
		d.Ordinality AS dOrdinality,
		d.UUID AS dUUID,

		dt.DataID AS dtDataID,
		dt.DictionaryID AS dtDictionaryID,
		dt.Name AS dtName,
		dt.Label AS dtLabel,
		dt.Value AS dtValue,
		dt.DDataTypeID AS dtDDataTypeID,
		dt.ParentDataID AS dtParentDataID,
		dt.Ordinality AS dtOrdinality,
		dt.UUID AS dtUUID
	FROM
		Dictionary d WITH (NOLOCK)
		INNER JOIN Data dt WITH (NOLOCK)
			ON d.DictionaryID = dt.DictionaryID
	WHERE
		d.DictionaryID < 1000
)
GO