<?PHP
 return
array (
  'DBSTRUCT_META' => array (
    'DRIVER_NAME' => 'mysql',
    'SERIAL' => 1464182835,
    'TIME' => '2016-05-25T15:27:15+02:00',
    'HOSTNAME' => 'mafalda',
  ),
  'SCHEMA_META' => array (
    'SCHEMA_NAME' => 'ogerarch-dev-next',
    'DEFAULT_CHARACTER_SET_NAME' => 'utf8',
    'DEFAULT_COLLATION_NAME' => 'utf8_unicode_ci',
    'lower_case_file_system' => 'OFF',
    'lower_case_table_names' => '0',
    'version_compile_machine' => 'x86_64',
    'version_compile_os' => 'debian-linux-gnu',
    'innodb_version' => '5.5.49',
    'protocol_version' => '10',
    'slave_type_conversions' => '',
    'version' => '5.5.49-0ubuntu0.14.04.1',
    'version_comment' => '(Ubuntu)',
  ),
  'TABLES' => array (
    'archfind' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'archFind', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'archfindid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'archFindId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'archfindidsort' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'archFindIdSort', 'COLUMN_TYPE' => 'char(50)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'date' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'date', 'COLUMN_TYPE' => 'date', 'DATA_TYPE' => 'date', 'IS_NULLABLE' => 'NO',  ),
        'fieldname' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'fieldName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plotname' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'plotName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'section' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'section', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'area' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'area', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'profile' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'profile', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'atsteplowering' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'atStepLowering', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'atstepcleaningraw' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'atStepCleaningRaw', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'atstepcleaningfine' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'atStepCleaningFine', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'atstepother' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'atStepOther', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'isstrayfind' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'isStrayFind', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'interpretation' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'interpretation', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingspec' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'datingSpec', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingperiodid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'datingPeriodId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'planname' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'planName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'interfaceidlist' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'interfaceIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'archobjectidlist' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'archObjectIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'archobjgroupidlist' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'archObjGroupIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'specialarchfind' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'specialArchFind', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'ceramicscountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'ceramicsCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'animalbonecountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'animalBoneCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'humanbonecountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'humanBoneCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'ferrouscountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'ferrousCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'nonferrousmetalcountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'nonFerrousMetalCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'glasscountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'glassCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'architecturalceramicscountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'architecturalCeramicsCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'daubcountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'daubCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'stonecountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'stoneCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'silexcountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'silexCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'mortarcountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'mortarCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'timbercountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'timberCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'organic' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'organic', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'archfindother' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'archFindOther', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'sedimentsamplecountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'sedimentSampleCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'slurrysamplecountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'slurrySampleCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'charcoalsamplecountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'charcoalSampleCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'mortarsamplecountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'mortarSampleCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'slagsamplecountid' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'slagSampleCountId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'sampleother' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'sampleOther', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'comment' => array ( 'TABLE_NAME' => 'archFind', 'COLUMN_NAME' => 'comment', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_find' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_find', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'archFind',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archFind', 'INDEX_NAME' => 'excav_find', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'archfindid' => array ( 'TABLE_NAME' => 'archFind', 'INDEX_NAME' => 'excav_find', 'COLUMN_NAME' => 'archFindId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'excav_findsort' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_findSort', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'archFind',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archFind', 'INDEX_NAME' => 'excav_findSort', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'archfindidsort' => array ( 'TABLE_NAME' => 'archFind', 'INDEX_NAME' => 'excav_findSort', 'COLUMN_NAME' => 'archFindIdSort', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'archFind',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'archFind', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'archfind_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'archFind_ibfk_1', 'TABLE_NAME' => 'archFind', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archFind', 'CONSTRAINT_NAME' => 'archFind_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'archfindcatalog' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'archFindCatalog', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'excavid' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'catalogid' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'catalogId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci', 'COLUMN_KEY' => 'PRI',  ),
        'partid' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'partId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'archfindid' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'archFindId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci', 'COLUMN_KEY' => 'MUL',  ),
        'denotation' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'denotation', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'type' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'type', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'subtype' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'subType', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'material' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'material', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'lengthvalue' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'lengthValue', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'width' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'width', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'height' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'height', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'diameter' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'diaMeter', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'description' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'description', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'comment' => array ( 'TABLE_NAME' => 'archFindCatalog', 'COLUMN_NAME' => 'comment', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'archfindid' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'archFindId', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'archFindCatalog',  ),
          'INDEX_COLUMNS' => array (
            'archfindid' => array ( 'TABLE_NAME' => 'archFindCatalog', 'INDEX_NAME' => 'archFindId', 'COLUMN_NAME' => 'archFindId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'archFindCatalog',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archFindCatalog', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'catalogid' => array ( 'TABLE_NAME' => 'archFindCatalog', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'catalogId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'partid' => array ( 'TABLE_NAME' => 'archFindCatalog', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'partId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'archfindcatalog_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'archFindCatalog_ibfk_1', 'TABLE_NAME' => 'archFindCatalog', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archFindCatalog', 'CONSTRAINT_NAME' => 'archFindCatalog_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'archobjgroup' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'archObjGroup', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'archObjGroup', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'archObjGroup', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'archobjgroupid' => array ( 'TABLE_NAME' => 'archObjGroup', 'COLUMN_NAME' => 'archObjGroupId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'typeid' => array ( 'TABLE_NAME' => 'archObjGroup', 'COLUMN_NAME' => 'typeId', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'typeserial' => array ( 'TABLE_NAME' => 'archObjGroup', 'COLUMN_NAME' => 'typeSerial', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'interpretation' => array ( 'TABLE_NAME' => 'archObjGroup', 'COLUMN_NAME' => 'interpretation', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingspec' => array ( 'TABLE_NAME' => 'archObjGroup', 'COLUMN_NAME' => 'datingSpec', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingperiodid' => array ( 'TABLE_NAME' => 'archObjGroup', 'COLUMN_NAME' => 'datingPeriodId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'comment' => array ( 'TABLE_NAME' => 'archObjGroup', 'COLUMN_NAME' => 'comment', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'listcomment' => array ( 'TABLE_NAME' => 'archObjGroup', 'COLUMN_NAME' => 'listComment', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_objgroup' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_objgroup', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'archObjGroup',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archObjGroup', 'INDEX_NAME' => 'excav_objgroup', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'archobjgroupid' => array ( 'TABLE_NAME' => 'archObjGroup', 'INDEX_NAME' => 'excav_objgroup', 'COLUMN_NAME' => 'archObjGroupId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'archObjGroup',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'archObjGroup', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'archobjgroup_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'archObjGroup_ibfk_1', 'TABLE_NAME' => 'archObjGroup', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archObjGroup', 'CONSTRAINT_NAME' => 'archObjGroup_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'archobjgrouptoarchobject' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'archObjGroupToArchObject', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'archObjGroupToArchObject', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'archObjGroupToArchObject', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'archobjgroupid' => array ( 'TABLE_NAME' => 'archObjGroupToArchObject', 'COLUMN_NAME' => 'archObjGroupId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'archobjectid' => array ( 'TABLE_NAME' => 'archObjGroupToArchObject', 'COLUMN_NAME' => 'archObjectId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_object' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_object', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'archObjGroupToArchObject',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archObjGroupToArchObject', 'INDEX_NAME' => 'excav_object', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
            'archobjectid' => array ( 'TABLE_NAME' => 'archObjGroupToArchObject', 'INDEX_NAME' => 'excav_object', 'COLUMN_NAME' => 'archObjectId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'excav_objgroup' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_objgroup', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'archObjGroupToArchObject',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archObjGroupToArchObject', 'INDEX_NAME' => 'excav_objgroup', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
            'archobjgroupid' => array ( 'TABLE_NAME' => 'archObjGroupToArchObject', 'INDEX_NAME' => 'excav_objgroup', 'COLUMN_NAME' => 'archObjGroupId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'archObjGroupToArchObject',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'archObjGroupToArchObject', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'archobjgrouptoarchobject_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'archObjGroupToArchObject_ibfk_1', 'TABLE_NAME' => 'archObjGroupToArchObject', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archObjGroupToArchObject', 'CONSTRAINT_NAME' => 'archObjGroupToArchObject_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'archobjgrouptype' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'archObjGroupType', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'archObjGroupType', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'name' => array ( 'TABLE_NAME' => 'archObjGroupType', 'COLUMN_NAME' => 'name', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'code' => array ( 'TABLE_NAME' => 'archObjGroupType', 'COLUMN_NAME' => 'code', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'begindate' => array ( 'TABLE_NAME' => 'archObjGroupType', 'COLUMN_NAME' => 'beginDate', 'COLUMN_TYPE' => 'date', 'DATA_TYPE' => 'date', 'IS_NULLABLE' => 'NO',  ),
        'enddate' => array ( 'TABLE_NAME' => 'archObjGroupType', 'COLUMN_NAME' => 'endDate', 'COLUMN_TYPE' => 'date', 'DATA_TYPE' => 'date', 'IS_NULLABLE' => 'NO',  ),
      ),
      'INDICES' => array (
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'archObjGroupType',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'archObjGroupType', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
    ),
    'archobject' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'archObject', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'archObject', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'archObject', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'archobjectid' => array ( 'TABLE_NAME' => 'archObject', 'COLUMN_NAME' => 'archObjectId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'typeid' => array ( 'TABLE_NAME' => 'archObject', 'COLUMN_NAME' => 'typeId', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'typeserial' => array ( 'TABLE_NAME' => 'archObject', 'COLUMN_NAME' => 'typeSerial', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'interpretation' => array ( 'TABLE_NAME' => 'archObject', 'COLUMN_NAME' => 'interpretation', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingspec' => array ( 'TABLE_NAME' => 'archObject', 'COLUMN_NAME' => 'datingSpec', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingperiodid' => array ( 'TABLE_NAME' => 'archObject', 'COLUMN_NAME' => 'datingPeriodId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'comment' => array ( 'TABLE_NAME' => 'archObject', 'COLUMN_NAME' => 'comment', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'listcomment' => array ( 'TABLE_NAME' => 'archObject', 'COLUMN_NAME' => 'listComment', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_object' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_object', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'archObject',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archObject', 'INDEX_NAME' => 'excav_object', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'archobjectid' => array ( 'TABLE_NAME' => 'archObject', 'INDEX_NAME' => 'excav_object', 'COLUMN_NAME' => 'archObjectId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'archObject',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'archObject', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'archobject_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'archObject_ibfk_1', 'TABLE_NAME' => 'archObject', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archObject', 'CONSTRAINT_NAME' => 'archObject_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'archobjecttostratum' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'archObjectToStratum', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'archObjectToStratum', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'archObjectToStratum', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'archobjectid' => array ( 'TABLE_NAME' => 'archObjectToStratum', 'COLUMN_NAME' => 'archObjectId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'stratumid' => array ( 'TABLE_NAME' => 'archObjectToStratum', 'COLUMN_NAME' => 'stratumId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_object' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_object', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'archObjectToStratum',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archObjectToStratum', 'INDEX_NAME' => 'excav_object', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
            'archobjectid' => array ( 'TABLE_NAME' => 'archObjectToStratum', 'INDEX_NAME' => 'excav_object', 'COLUMN_NAME' => 'archObjectId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'excav_stratum' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_stratum', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'archObjectToStratum',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archObjectToStratum', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
            'stratumid' => array ( 'TABLE_NAME' => 'archObjectToStratum', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'stratumId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'archObjectToStratum',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'archObjectToStratum', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'archobjecttostratum_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'archObjectToStratum_ibfk_1', 'TABLE_NAME' => 'archObjectToStratum', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'archObjectToStratum', 'CONSTRAINT_NAME' => 'archObjectToStratum_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'archobjecttype' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'archObjectType', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'archObjectType', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'name' => array ( 'TABLE_NAME' => 'archObjectType', 'COLUMN_NAME' => 'name', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'code' => array ( 'TABLE_NAME' => 'archObjectType', 'COLUMN_NAME' => 'code', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'begindate' => array ( 'TABLE_NAME' => 'archObjectType', 'COLUMN_NAME' => 'beginDate', 'COLUMN_TYPE' => 'date', 'DATA_TYPE' => 'date', 'IS_NULLABLE' => 'NO',  ),
        'enddate' => array ( 'TABLE_NAME' => 'archObjectType', 'COLUMN_NAME' => 'endDate', 'COLUMN_TYPE' => 'date', 'DATA_TYPE' => 'date', 'IS_NULLABLE' => 'NO',  ),
      ),
      'INDICES' => array (
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'archObjectType',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'archObjectType', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
    ),
    'cadastralaustria' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'cadastralAustria', 'ENGINE' => 'MyISAM', 'TABLE_COLLATION' => 'utf8_general_ci',  ),
      'COLUMNS' => array (
        'cadastralid' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'cadastralId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'name' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'name', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_general_ci',  ),
        'districtname' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'districtName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_general_ci',  ),
        'surveyofficename' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'surveyOfficeName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_general_ci',  ),
        'regionid' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'regionId', 'COLUMN_TYPE' => 'varchar(10)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '10', 'CHARACTER_OCTET_LENGTH' => '30', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_general_ci',  ),
        'unknown1' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'unknown1', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'communeid' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'communeId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'communename' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'communeName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_general_ci',  ),
        'unknown2' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'unknown2', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'geo1a' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'geo1a', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'geo1b' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'geo1b', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'geo2a' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'geo2a', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'geo2b' => array ( 'TABLE_NAME' => 'cadastralAustria', 'COLUMN_NAME' => 'geo2b', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
      ),
      'INDICES' => array (
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'cadastralAustria',  ),
          'INDEX_COLUMNS' => array (
            'cadastralid' => array ( 'TABLE_NAME' => 'cadastralAustria', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'cadastralId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
    ),
    'company' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'company', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'company', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'name1' => array ( 'TABLE_NAME' => 'company', 'COLUMN_NAME' => 'name1', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'name2' => array ( 'TABLE_NAME' => 'company', 'COLUMN_NAME' => 'name2', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'street' => array ( 'TABLE_NAME' => 'company', 'COLUMN_NAME' => 'street', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'postalcode' => array ( 'TABLE_NAME' => 'company', 'COLUMN_NAME' => 'postalCode', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'city' => array ( 'TABLE_NAME' => 'company', 'COLUMN_NAME' => 'city', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'countryname' => array ( 'TABLE_NAME' => 'company', 'COLUMN_NAME' => 'countryName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'shortname' => array ( 'TABLE_NAME' => 'company', 'COLUMN_NAME' => 'shortName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'company',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'company', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
    ),
    'dbstructlog' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'dbStructLog', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'dbStructLog', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI', 'EXTRA' => 'auto_increment',  ),
        'begintime' => array ( 'TABLE_NAME' => 'dbStructLog', 'COLUMN_NAME' => 'beginTime', 'COLUMN_TYPE' => 'datetime', 'DATA_TYPE' => 'datetime', 'IS_NULLABLE' => 'NO',  ),
        'structserial' => array ( 'TABLE_NAME' => 'dbStructLog', 'COLUMN_NAME' => 'structSerial', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'structtime' => array ( 'TABLE_NAME' => 'dbStructLog', 'COLUMN_NAME' => 'structTime', 'COLUMN_TYPE' => 'datetime', 'DATA_TYPE' => 'datetime', 'IS_NULLABLE' => 'NO',  ),
        'precheck' => array ( 'TABLE_NAME' => 'dbStructLog', 'COLUMN_NAME' => 'preCheck', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'cmdlog' => array ( 'TABLE_NAME' => 'dbStructLog', 'COLUMN_NAME' => 'cmdLog', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'log' => array ( 'TABLE_NAME' => 'dbStructLog', 'COLUMN_NAME' => 'log', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'error' => array ( 'TABLE_NAME' => 'dbStructLog', 'COLUMN_NAME' => 'error', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'postcheck' => array ( 'TABLE_NAME' => 'dbStructLog', 'COLUMN_NAME' => 'postCheck', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'surplus' => array ( 'TABLE_NAME' => 'dbStructLog', 'COLUMN_NAME' => 'surplus', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'endtime' => array ( 'TABLE_NAME' => 'dbStructLog', 'COLUMN_NAME' => 'endTime', 'COLUMN_TYPE' => 'datetime', 'DATA_TYPE' => 'datetime', 'IS_NULLABLE' => 'NO',  ),
      ),
      'INDICES' => array (
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'dbStructLog',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'dbStructLog', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
    ),
    'excavation' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'excavation', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'name' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'name', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'excavmethodid' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'excavMethodId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'begindate' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'beginDate', 'COLUMN_TYPE' => 'date', 'DATA_TYPE' => 'date', 'IS_NULLABLE' => 'NO',  ),
        'enddate' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'endDate', 'COLUMN_TYPE' => 'date', 'DATA_TYPE' => 'date', 'IS_NULLABLE' => 'NO',  ),
        'authorizedperson' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'authorizedPerson', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'originator' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'originator', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'officialid' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'officialId', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'officialid2' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'officialId2', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'countryname' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'countryName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'regionname' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'regionName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'districtname' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'districtName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'communename' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'communeName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'cadastralcommunityname' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'cadastralCommunityName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'fieldname' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'fieldName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plotname' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'plotName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingspec' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'datingSpec', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingperiodid' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'datingPeriodId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'gpsx' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'gpsX', 'COLUMN_TYPE' => 'decimal(20,10)', 'DATA_TYPE' => 'decimal', 'COLUMN_DEFAULT' => NULL, 'IS_NULLABLE' => 'YES', 'NUMERIC_PRECISION' => '20', 'NUMERIC_SCALE' => '10',  ),
        'gpsy' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'gpsY', 'COLUMN_TYPE' => 'decimal(20,10)', 'DATA_TYPE' => 'decimal', 'COLUMN_DEFAULT' => NULL, 'IS_NULLABLE' => 'YES', 'NUMERIC_PRECISION' => '20', 'NUMERIC_SCALE' => '10',  ),
        'gpsz' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'gpsZ', 'COLUMN_TYPE' => 'decimal(20,10)', 'DATA_TYPE' => 'decimal', 'COLUMN_DEFAULT' => NULL, 'IS_NULLABLE' => 'YES', 'NUMERIC_PRECISION' => '20', 'NUMERIC_SCALE' => '10',  ),
        'comment' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'comment', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'projectbasedir' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'projectBaseDir', 'COLUMN_TYPE' => 'varchar(1024)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '1024', 'CHARACTER_OCTET_LENGTH' => '3072', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'inactive' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'inactive', 'COLUMN_TYPE' => 'tinyint(1)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'emailbda' => array ( 'TABLE_NAME' => 'excavation', 'COLUMN_NAME' => 'emailBda', 'COLUMN_TYPE' => 'varchar(100)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '100', 'CHARACTER_OCTET_LENGTH' => '300', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'excavation',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'excavation', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
    ),
    'pdftemplate' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'pdfTemplate', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'pdfTemplate', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'sectionid' => array ( 'TABLE_NAME' => 'pdfTemplate', 'COLUMN_NAME' => 'sectionId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'name' => array ( 'TABLE_NAME' => 'pdfTemplate', 'COLUMN_NAME' => 'name', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'template' => array ( 'TABLE_NAME' => 'pdfTemplate', 'COLUMN_NAME' => 'template', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'description' => array ( 'TABLE_NAME' => 'pdfTemplate', 'COLUMN_NAME' => 'description', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'pdfTemplate',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'pdfTemplate', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
    ),
    'picturefile' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'pictureFile', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'filename' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'fileName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'mimetype' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'mimeType', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'filesize' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'fileSize', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'isexternal' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'isExternal', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'content' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'content', 'COLUMN_TYPE' => 'longblob', 'DATA_TYPE' => 'longblob', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '4294967295', 'CHARACTER_OCTET_LENGTH' => '4294967295',  ),
        'externalstorefilename' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'externalStoreFileName', 'COLUMN_TYPE' => 'varchar(1024)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '1024', 'CHARACTER_OCTET_LENGTH' => '3072', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'date' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'date', 'COLUMN_TYPE' => 'date', 'DATA_TYPE' => 'date', 'IS_NULLABLE' => 'NO',  ),
        'title' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'title', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'isoverview' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'isOverview', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'relevance' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'relevance', 'COLUMN_TYPE' => 'varchar(11)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '11', 'CHARACTER_OCTET_LENGTH' => '33', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'auxstratumidlist' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'auxStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'auxarchfindidlist' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'auxArchFindIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'auxsection' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'auxSection', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'auxsektor' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'auxSektor', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'auxplanum' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'auxPlanum', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'auxprofile' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'auxProfile', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'auxobject' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'auxObject', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'auxgrave' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'auxGrave', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'auxwall' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'auxWall', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'auxcomplex' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'auxComplex', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'comment' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'comment', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingperiodid' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'datingPeriodId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingspec' => array ( 'TABLE_NAME' => 'pictureFile', 'COLUMN_NAME' => 'datingSpec', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excavid' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excavId', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'pictureFile',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'pictureFile', 'INDEX_NAME' => 'excavId', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'pictureFile',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'pictureFile', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'picturefile_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'pictureFile_ibfk_1', 'TABLE_NAME' => 'pictureFile', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'pictureFile', 'CONSTRAINT_NAME' => 'pictureFile_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'prepfindtmpnew' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'iid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'iid', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI', 'EXTRA' => 'auto_increment',  ),
        'excavid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'archfindid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'archFindId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'archfindidsort' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'archFindIdSort', 'COLUMN_TYPE' => 'char(50)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'archfindsubid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'archFindSubId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'archfindsubidsort' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'archFindSubIdSort', 'COLUMN_TYPE' => 'char(50)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'stocklocationid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'stockLocationId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'oriarchfindid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'oriArchFindId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingspec' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'datingSpec', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'specialarchfind' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'specialArchFind', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'ceramicscountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'ceramicsCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'animalbonecountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'animalBoneCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'humanbonecountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'humanBoneCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'ferrouscountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'ferrousCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'nonferrousmetalcountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'nonFerrousMetalCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'glasscountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'glassCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'architecturalceramicscountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'architecturalCeramicsCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'daubcountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'daubCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'stonecountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'stoneCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'silexcountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'silexCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'mortarcountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'mortarCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'timbercountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'timberCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'organic' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'organic', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'archfindother' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'archFindOther', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'sedimentsamplecountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'sedimentSampleCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'slurrysamplecountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'slurrySampleCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'charcoalsamplecountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'charcoalSampleCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'mortarsamplecountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'mortarSampleCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'slagsamplecountid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'slagSampleCountId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'sampleother' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'sampleOther', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'washstatusid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'washStatusId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'labelstatusid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'labelStatusId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'restorestatusid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'restoreStatusId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'photographstatusid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'photographStatusId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'drawstatusid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'drawStatusId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'layoutstatusid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'layoutStatusId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'scientificstatusid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'scientificStatusId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'publishstatusid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'publishStatusId', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'comment' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'COLUMN_NAME' => 'comment', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excavid' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excavId', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'prepFindTMPNEW',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'INDEX_NAME' => 'excavId', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'excav_findsort' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_findSort', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'prepFindTMPNEW',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'INDEX_NAME' => 'excav_findSort', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
            'archfindidsort' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'INDEX_NAME' => 'excav_findSort', 'COLUMN_NAME' => 'archFindIdSort', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'excav_find_sub' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_find_sub', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'prepFindTMPNEW',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'INDEX_NAME' => 'excav_find_sub', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'archfindid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'INDEX_NAME' => 'excav_find_sub', 'COLUMN_NAME' => 'archFindId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'archfindsubid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'INDEX_NAME' => 'excav_find_sub', 'COLUMN_NAME' => 'archFindSubId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'prepFindTMPNEW',  ),
          'INDEX_COLUMNS' => array (
            'iid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'iid', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'stocklocationid' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'stockLocationId', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'prepFindTMPNEW',  ),
          'INDEX_COLUMNS' => array (
            'stocklocationid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'INDEX_NAME' => 'stockLocationId', 'COLUMN_NAME' => 'stockLocationId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'prepfindtmpnew_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'prepFindTMPNEW_ibfk_1', 'TABLE_NAME' => 'prepFindTMPNEW', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'CONSTRAINT_NAME' => 'prepFindTMPNEW_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
        'prepfindtmpnew_ibfk_2' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'prepFindTMPNEW_ibfk_2', 'TABLE_NAME' => 'prepFindTMPNEW', 'REFERENCED_TABLE_NAME' => 'stockLocation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'stocklocationid' => array ( 'TABLE_NAME' => 'prepFindTMPNEW', 'CONSTRAINT_NAME' => 'prepFindTMPNEW_ibfk_2', 'COLUMN_NAME' => 'stockLocationId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'stockLocation', 'REFERENCED_COLUMN_NAME' => 'stockLocationId',  ),
          ),
        ),
      ),
    ),
    'stocklocation' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'stockLocation', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'stocklocationid' => array ( 'TABLE_NAME' => 'stockLocation', 'COLUMN_NAME' => 'stockLocationId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI', 'EXTRA' => 'auto_increment',  ),
        'excavid' => array ( 'TABLE_NAME' => 'stockLocation', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'COLUMN_DEFAULT' => NULL, 'IS_NULLABLE' => 'YES', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'name' => array ( 'TABLE_NAME' => 'stockLocation', 'COLUMN_NAME' => 'name', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'outerid' => array ( 'TABLE_NAME' => 'stockLocation', 'COLUMN_NAME' => 'outerId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'movable' => array ( 'TABLE_NAME' => 'stockLocation', 'COLUMN_NAME' => 'movable', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'reusable' => array ( 'TABLE_NAME' => 'stockLocation', 'COLUMN_NAME' => 'reusable', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'typeid' => array ( 'TABLE_NAME' => 'stockLocation', 'COLUMN_NAME' => 'typeId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'maxinnertypeid' => array ( 'TABLE_NAME' => 'stockLocation', 'COLUMN_NAME' => 'maxInnerTypeId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'canitem' => array ( 'TABLE_NAME' => 'stockLocation', 'COLUMN_NAME' => 'canItem', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'canexcavmovable' => array ( 'TABLE_NAME' => 'stockLocation', 'COLUMN_NAME' => 'canExcavMovable', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'canreusablemovable' => array ( 'TABLE_NAME' => 'stockLocation', 'COLUMN_NAME' => 'canReusableMovable', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'contentcomment' => array ( 'TABLE_NAME' => 'stockLocation', 'COLUMN_NAME' => 'contentComment', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excavid' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excavId', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'stockLocation',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stockLocation', 'INDEX_NAME' => 'excavId', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'stockLocation',  ),
          'INDEX_COLUMNS' => array (
            'stocklocationid' => array ( 'TABLE_NAME' => 'stockLocation', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'stockLocationId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'stocklocation_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'stockLocation_ibfk_1', 'TABLE_NAME' => 'stockLocation', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stockLocation', 'CONSTRAINT_NAME' => 'stockLocation_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'stocklocationtype' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'stockLocationType', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'stockLocationType', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI', 'EXTRA' => 'auto_increment',  ),
        'name' => array ( 'TABLE_NAME' => 'stockLocationType', 'COLUMN_NAME' => 'name', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'sizeclass' => array ( 'TABLE_NAME' => 'stockLocationType', 'COLUMN_NAME' => 'sizeClass', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'excavvisible' => array ( 'TABLE_NAME' => 'stockLocationType', 'COLUMN_NAME' => 'excavVisible', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
      ),
      'INDICES' => array (
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'stockLocationType',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'stockLocationType', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
    ),
    'stratum' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'stratum', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'stratumid' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'stratumId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'stratumidsort' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'stratumIdSort', 'COLUMN_TYPE' => 'char(50)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'categoryid' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'categoryId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'date' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'date', 'COLUMN_TYPE' => 'date', 'DATA_TYPE' => 'date', 'IS_NULLABLE' => 'NO',  ),
        'originator' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'originator', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'fieldname' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'fieldName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plotname' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'plotName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'section' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'section', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'area' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'area', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'profile' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'profile', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'typeid' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'typeId', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'interpretation' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'interpretation', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingspec' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'datingSpec', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingperiodid' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'datingPeriodId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'picturereference' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'pictureReference', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plandigital' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'planDigital', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'plananalog' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'planAnalog', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'photogrammetry' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'photogrammetry', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'photodigital' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'photoDigital', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'photoslide' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'photoSlide', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'photoprint' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'photoPrint', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'lengthvalue' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'lengthValue', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'width' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'width', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'height' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'height', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'diameter' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'diaMeter', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'hasarchfind' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'hasArchFind', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'hassample' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'hasSample', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'hasarchobject' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'hasArchObject', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'hasarchobjgroup' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'hasArchObjGroup', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'comment' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'comment', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'listcomment' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'listComment', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'istopedge' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'isTopEdge', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'isbottomedge' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'isBottomEdge', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'hasautointerface' => array ( 'TABLE_NAME' => 'stratum', 'COLUMN_NAME' => 'hasAutoInterface', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
      ),
      'INDICES' => array (
        'excav_stratum' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_stratum', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'stratum',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratum', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'stratumid' => array ( 'TABLE_NAME' => 'stratum', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'stratumId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'excv_stratumsort' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excv_stratumSort', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'stratum',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratum', 'INDEX_NAME' => 'excv_stratumSort', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'stratumidsort' => array ( 'TABLE_NAME' => 'stratum', 'INDEX_NAME' => 'excv_stratumSort', 'COLUMN_NAME' => 'stratumIdSort', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'stratum',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'stratum', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'stratum_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'stratum_ibfk_1', 'TABLE_NAME' => 'stratum', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratum', 'CONSTRAINT_NAME' => 'stratum_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'stratumcomplex' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'stratumComplex', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'stratumComplex', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'stratumComplex', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'stratumid' => array ( 'TABLE_NAME' => 'stratumComplex', 'COLUMN_NAME' => 'stratumId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'stratum2id' => array ( 'TABLE_NAME' => 'stratumComplex', 'COLUMN_NAME' => 'stratum2Id', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_stratum' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_stratum', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'stratumComplex',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumComplex', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
            'stratumid' => array ( 'TABLE_NAME' => 'stratumComplex', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'stratumId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'stratumComplex',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'stratumComplex', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'stratumcomplex_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'stratumComplex_ibfk_1', 'TABLE_NAME' => 'stratumComplex', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumComplex', 'CONSTRAINT_NAME' => 'stratumComplex_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'stratumdeposit' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'stratumDeposit', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'stratumDeposit', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'stratumDeposit', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'stratumid' => array ( 'TABLE_NAME' => 'stratumDeposit', 'COLUMN_NAME' => 'stratumId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'color' => array ( 'TABLE_NAME' => 'stratumDeposit', 'COLUMN_NAME' => 'color', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'hardness' => array ( 'TABLE_NAME' => 'stratumDeposit', 'COLUMN_NAME' => 'hardness', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'consistency' => array ( 'TABLE_NAME' => 'stratumDeposit', 'COLUMN_NAME' => 'consistency', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'inclusion' => array ( 'TABLE_NAME' => 'stratumDeposit', 'COLUMN_NAME' => 'inclusion', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'orientation' => array ( 'TABLE_NAME' => 'stratumDeposit', 'COLUMN_NAME' => 'orientation', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'incline' => array ( 'TABLE_NAME' => 'stratumDeposit', 'COLUMN_NAME' => 'incline', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'materialdenotation' => array ( 'TABLE_NAME' => 'stratumDeposit', 'COLUMN_NAME' => 'materialDenotation', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_stratum' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_stratum', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'stratumDeposit',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumDeposit', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'stratumid' => array ( 'TABLE_NAME' => 'stratumDeposit', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'stratumId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'stratumDeposit',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'stratumDeposit', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'stratumdeposit_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'stratumDeposit_ibfk_1', 'TABLE_NAME' => 'stratumDeposit', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumDeposit', 'CONSTRAINT_NAME' => 'stratumDeposit_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'stratuminterface' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'stratumInterface', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'stratumInterface', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'stratumInterface', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'stratumid' => array ( 'TABLE_NAME' => 'stratumInterface', 'COLUMN_NAME' => 'stratumId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'shape' => array ( 'TABLE_NAME' => 'stratumInterface', 'COLUMN_NAME' => 'shape', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'contour' => array ( 'TABLE_NAME' => 'stratumInterface', 'COLUMN_NAME' => 'contour', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'intersection' => array ( 'TABLE_NAME' => 'stratumInterface', 'COLUMN_NAME' => 'intersection', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'vertex' => array ( 'TABLE_NAME' => 'stratumInterface', 'COLUMN_NAME' => 'vertex', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'sidewall' => array ( 'TABLE_NAME' => 'stratumInterface', 'COLUMN_NAME' => 'sidewall', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'basis' => array ( 'TABLE_NAME' => 'stratumInterface', 'COLUMN_NAME' => 'basis', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_stratum' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_stratum', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'stratumInterface',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumInterface', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'stratumid' => array ( 'TABLE_NAME' => 'stratumInterface', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'stratumId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'stratumInterface',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'stratumInterface', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'stratuminterface_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'stratumInterface_ibfk_1', 'TABLE_NAME' => 'stratumInterface', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumInterface', 'CONSTRAINT_NAME' => 'stratumInterface_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'stratummatrix' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'stratumMatrix', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'stratumMatrix', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'stratumMatrix', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'stratumid' => array ( 'TABLE_NAME' => 'stratumMatrix', 'COLUMN_NAME' => 'stratumId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'relation' => array ( 'TABLE_NAME' => 'stratumMatrix', 'COLUMN_NAME' => 'relation', 'COLUMN_TYPE' => 'char(2)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '2', 'CHARACTER_OCTET_LENGTH' => '6', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'stratum2id' => array ( 'TABLE_NAME' => 'stratumMatrix', 'COLUMN_NAME' => 'stratum2Id', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_stratum' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_stratum', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'stratumMatrix',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumMatrix', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
            'stratumid' => array ( 'TABLE_NAME' => 'stratumMatrix', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'stratumId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'stratumMatrix',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'stratumMatrix', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'stratummatrix_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'stratumMatrix_ibfk_1', 'TABLE_NAME' => 'stratumMatrix', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumMatrix', 'CONSTRAINT_NAME' => 'stratumMatrix_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'stratumskeleton' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'stratumid' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'stratumId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'bodyposition' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'bodyPosition', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'orientation' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'orientation', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'bonequality' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'boneQuality', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'dislocationnone' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'dislocationNone', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'dislocationbase' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'dislocationBase', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'dislocationshaft' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'dislocationShaft', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'dislocationprivation' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'dislocationPrivation', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'dislocationden' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'dislocationDen', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'recoverysinglebones' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'recoverySingleBones', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'recoveryblock' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'recoveryBlock', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'recoveryhardened' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'recoveryHardened', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'specialburial' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'specialBurial', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'viewdirection' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'viewDirection', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'legposition' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'legPosition', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'armposition' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'armPosition', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'positiondescription' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'positionDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'upperarmrightlength' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'upperArmRightLength', 'COLUMN_TYPE' => 'varchar(11)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '11', 'CHARACTER_OCTET_LENGTH' => '33', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'upperarmleftlength' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'upperArmLeftLength', 'COLUMN_TYPE' => 'varchar(11)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '11', 'CHARACTER_OCTET_LENGTH' => '33', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'forearmrightlength' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'foreArmRightLength', 'COLUMN_TYPE' => 'varchar(11)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '11', 'CHARACTER_OCTET_LENGTH' => '33', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'forearmleftlength' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'foreArmLeftLength', 'COLUMN_TYPE' => 'varchar(11)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '11', 'CHARACTER_OCTET_LENGTH' => '33', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'thighrightlength' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'thighRightLength', 'COLUMN_TYPE' => 'varchar(11)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '11', 'CHARACTER_OCTET_LENGTH' => '33', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'thighleftlength' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'thighLeftLength', 'COLUMN_TYPE' => 'varchar(11)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '11', 'CHARACTER_OCTET_LENGTH' => '33', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'shinrightlength' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'shinRightLength', 'COLUMN_TYPE' => 'varchar(11)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '11', 'CHARACTER_OCTET_LENGTH' => '33', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'shinleftlength' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'shinLeftLength', 'COLUMN_TYPE' => 'varchar(11)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '11', 'CHARACTER_OCTET_LENGTH' => '33', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'bodylength' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'bodyLength', 'COLUMN_TYPE' => 'varchar(11)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '11', 'CHARACTER_OCTET_LENGTH' => '33', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'sex' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'sex', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'gender' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'gender', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'age' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'age', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'burialcremationid' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'burialCremationId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'cremationdemagestratumidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'cremationDemageStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'cremationdemagedescription' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'cremationDemageDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'coffinstratumidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'coffinStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombtimberstratumidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombTimberStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombstonestratumidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombStoneStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombbrickstratumidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombBrickStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombothermaterialstratumidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombOtherMaterialStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombformcirclestratumidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombFormCircleStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombformovalstratumidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombFormOvalStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombformrectanglestratumidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombFormRectangleStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombformsquarestratumidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombFormSquareStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombformotherstratumidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombFormOtherStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombdemagestratumidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombDemageStratumIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombdemageformid' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombDemageFormId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombdescription' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'burialobjectarchfindidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'burialObjectArchFindIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'costumearchfindidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'costumeArchFindIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'depositarchfindidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'depositArchFindIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'tombconstructarchfindidlist' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'COLUMN_NAME' => 'tombConstructArchFindIdList', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_stratum' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_stratum', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'stratumSkeleton',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'stratumid' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'stratumId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'stratumSkeleton',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'stratumskeleton_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'stratumSkeleton_ibfk_1', 'TABLE_NAME' => 'stratumSkeleton', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumSkeleton', 'CONSTRAINT_NAME' => 'stratumSkeleton_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'stratumtimber' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'stratumTimber', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'stratumid' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'stratumId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'dendrochronology' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'dendrochronology', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'lengthapplyto' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'lengthApplyTo', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'widthapplyto' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'widthApplyTo', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'heightapplyto' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'heightApplyTo', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'orientation' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'orientation', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'functiondescription' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'functionDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'constructdescription' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'constructDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'relationdescription' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'relationDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'timbertype' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'timberType', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'infill' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'infill', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'otherconstructmaterial' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'otherConstructMaterial', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'surface' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'surface', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'preservationstatus' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'preservationStatus', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'physiozonedulledge' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'physioZoneDullEdge', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'physiozoneseapwood' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'physioZoneSeapWood', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'physiozoneheartwood' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'physioZoneHeartWood', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'secundaryusage' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'secundaryUsage', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'processsign' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'processSign', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'processdetail' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'processDetail', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'connection' => array ( 'TABLE_NAME' => 'stratumTimber', 'COLUMN_NAME' => 'connection', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_stratum' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_stratum', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'stratumTimber',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumTimber', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'stratumid' => array ( 'TABLE_NAME' => 'stratumTimber', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'stratumId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'stratumTimber',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'stratumTimber', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'stratumtimber_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'stratumTimber_ibfk_1', 'TABLE_NAME' => 'stratumTimber', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumTimber', 'CONSTRAINT_NAME' => 'stratumTimber_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'stratumtoarchfind' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'stratumToArchFind', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'stratumToArchFind', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'stratumToArchFind', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'stratumid' => array ( 'TABLE_NAME' => 'stratumToArchFind', 'COLUMN_NAME' => 'stratumId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'archfindid' => array ( 'TABLE_NAME' => 'stratumToArchFind', 'COLUMN_NAME' => 'archFindId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_archfind' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_archfind', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'stratumToArchFind',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumToArchFind', 'INDEX_NAME' => 'excav_archfind', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
            'archfindid' => array ( 'TABLE_NAME' => 'stratumToArchFind', 'INDEX_NAME' => 'excav_archfind', 'COLUMN_NAME' => 'archFindId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'excav_stratum' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_stratum', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'stratumToArchFind',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumToArchFind', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
            'stratumid' => array ( 'TABLE_NAME' => 'stratumToArchFind', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'stratumId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'stratumToArchFind',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'stratumToArchFind', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'stratumtoarchfind_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'stratumToArchFind_ibfk_1', 'TABLE_NAME' => 'stratumToArchFind', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumToArchFind', 'CONSTRAINT_NAME' => 'stratumToArchFind_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'stratumtype' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'stratumType', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'stratumType', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'categoryid' => array ( 'TABLE_NAME' => 'stratumType', 'COLUMN_NAME' => 'categoryId', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'name' => array ( 'TABLE_NAME' => 'stratumType', 'COLUMN_NAME' => 'name', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'code' => array ( 'TABLE_NAME' => 'stratumType', 'COLUMN_NAME' => 'code', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'begindate' => array ( 'TABLE_NAME' => 'stratumType', 'COLUMN_NAME' => 'beginDate', 'COLUMN_TYPE' => 'date', 'DATA_TYPE' => 'date', 'IS_NULLABLE' => 'NO',  ),
        'enddate' => array ( 'TABLE_NAME' => 'stratumType', 'COLUMN_NAME' => 'endDate', 'COLUMN_TYPE' => 'date', 'DATA_TYPE' => 'date', 'IS_NULLABLE' => 'NO',  ),
      ),
      'INDICES' => array (
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'stratumType',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'stratumType', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
    ),
    'stratumwall' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'stratumWall', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'excavid' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'excavId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'MUL',  ),
        'stratumid' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'stratumId', 'COLUMN_TYPE' => 'char(20)', 'DATA_TYPE' => 'char', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '20', 'CHARACTER_OCTET_LENGTH' => '60', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'datingstratigraphy' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'datingStratigraphy', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'datingwallstructure' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'datingWallStructure', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'lengthapplyto' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'lengthApplyTo', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'widthapplyto' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'widthApplyTo', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'heightraising' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'heightRaising', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'heightraisingapplyto' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'heightRaisingApplyTo', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'heightfooting' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'heightFooting', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'heightfootingapplyto' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'heightFootingApplyTo', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'constructiontype' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'constructionType', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'wallbasetype' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'wallBaseType', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'structuretype' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'structureType', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'relationdescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'relationDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'layerdescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'layerDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'shelldescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'shellDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'kerneldescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'kernelDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'formworkdescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'formworkDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'hasputloghole' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'hasPutlogHole', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'putlogholedescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'putlogHoleDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'hasbarhole' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'hasBarHole', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'barholedescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'barHoleDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'materialtype' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'materialType', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'stonesize' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'stoneSize', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'stonematerial' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'stoneMaterial', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'stoneprocessing' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'stoneProcessing', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'hascommonbrick' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'hasCommonBrick', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'hasvaultbrick' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'hasVaultBrick', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'hasrooftile' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'hasRoofTile', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'hasfortificationbrick' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'hasFortificationBrick', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'brickdescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'brickDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'hasproductionstampsign' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'hasProductionStampSign', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'hasproductionfingersign' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'hasProductionFingerSign', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'hasproductionotherattribute' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'hasProductionOtherAttribute', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'productiondescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'productionDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'mixedwallbrickpercent' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'mixedWallBrickPercent', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'mixedwalldescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'mixedWallDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'spoildescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'spoilDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'binderstate' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'binderState', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'bindertype' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'binderType', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'bindercolor' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'binderColor', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'bindersandpercent' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'binderSandPercent', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'binderlimevisible' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'binderLimeVisible', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'bindergrainsize' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'binderGrainSize', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'binderconsistency' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'binderConsistency', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'additivepebblesize' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'additivePebbleSize', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'additivelimepopsize' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'additiveLimepopSize', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'additivecrushedtilessize' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'additiveCrushedTilesSize', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'additivecharcoalsize' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'additiveCharcoalSize', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'additivestrawsize' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'additiveStrawSize', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'additiveothersize' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'additiveOtherSize', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'additiveotherdescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'additiveOtherDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'abreuvoirtype' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'abreuvoirType', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'abreuvoirdescription' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'abreuvoirDescription', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plastersurface' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'plasterSurface', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plasterthickness' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'plasterThickness', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plasterextend' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'plasterExtend', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plastercolor' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'plasterColor', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plastermixture' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'plasterMixture', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plastergrainsize' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'plasterGrainSize', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plasterconsistency' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'plasterConsistency', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plasteradditives' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'plasterAdditives', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'plasterlayer' => array ( 'TABLE_NAME' => 'stratumWall', 'COLUMN_NAME' => 'plasterLayer', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'excav_stratum' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'excav_stratum', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'stratumWall',  ),
          'INDEX_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumWall', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'excavId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'stratumid' => array ( 'TABLE_NAME' => 'stratumWall', 'INDEX_NAME' => 'excav_stratum', 'COLUMN_NAME' => 'stratumId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'stratumWall',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'stratumWall', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
      'FOREIGN_KEYS' => array (
        'stratumwall_ibfk_1' => array (
          'FOREIGN_KEY_META' => array ( 'FOREIGN_KEY_NAME' => 'stratumWall_ibfk_1', 'TABLE_NAME' => 'stratumWall', 'REFERENCED_TABLE_NAME' => 'excavation', 'MATCH_OPTION' => 'NONE', 'UPDATE_RULE' => 'RESTRICT', 'DELETE_RULE' => 'RESTRICT',  ),
          'FOREIGN_KEY_COLUMNS' => array (
            'excavid' => array ( 'TABLE_NAME' => 'stratumWall', 'CONSTRAINT_NAME' => 'stratumWall_ibfk_1', 'COLUMN_NAME' => 'excavId', 'POSITION_IN_UNIQUE_CONSTRAINT' => '1', 'REFERENCED_TABLE_NAME' => 'excavation', 'REFERENCED_COLUMN_NAME' => 'id',  ),
          ),
        ),
      ),
    ),
    'trash' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'trash', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'id' => array ( 'TABLE_NAME' => 'trash', 'COLUMN_NAME' => 'id', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI', 'EXTRA' => 'auto_increment',  ),
        'userid' => array ( 'TABLE_NAME' => 'trash', 'COLUMN_NAME' => 'userId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'username' => array ( 'TABLE_NAME' => 'trash', 'COLUMN_NAME' => 'userName', 'COLUMN_TYPE' => 'varchar(500)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '500', 'CHARACTER_OCTET_LENGTH' => '1500', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'time' => array ( 'TABLE_NAME' => 'trash', 'COLUMN_NAME' => 'time', 'COLUMN_TYPE' => 'datetime', 'DATA_TYPE' => 'datetime', 'IS_NULLABLE' => 'NO',  ),
        'type' => array ( 'TABLE_NAME' => 'trash', 'COLUMN_NAME' => 'type', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'content' => array ( 'TABLE_NAME' => 'trash', 'COLUMN_NAME' => 'content', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'trash',  ),
          'INDEX_COLUMNS' => array (
            'id' => array ( 'TABLE_NAME' => 'trash', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'id', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
    ),
    'user' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'user', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'userid' => array ( 'TABLE_NAME' => 'user', 'COLUMN_NAME' => 'userId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI', 'EXTRA' => 'auto_increment',  ),
        'logonname' => array ( 'TABLE_NAME' => 'user', 'COLUMN_NAME' => 'logonName', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci', 'COLUMN_KEY' => 'UNI',  ),
        'realname' => array ( 'TABLE_NAME' => 'user', 'COLUMN_NAME' => 'realName', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'password' => array ( 'TABLE_NAME' => 'user', 'COLUMN_NAME' => 'password', 'COLUMN_TYPE' => 'varchar(50)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '50', 'CHARACTER_OCTET_LENGTH' => '150', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'sslclientdn' => array ( 'TABLE_NAME' => 'user', 'COLUMN_NAME' => 'sslClientDN', 'COLUMN_TYPE' => 'varchar(1000)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '1000', 'CHARACTER_OCTET_LENGTH' => '3000', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'sslclientissuerdn' => array ( 'TABLE_NAME' => 'user', 'COLUMN_NAME' => 'sslClientIssuerDN', 'COLUMN_TYPE' => 'varchar(1000)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '1000', 'CHARACTER_OCTET_LENGTH' => '3000', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'logonperm' => array ( 'TABLE_NAME' => 'user', 'COLUMN_NAME' => 'logonPerm', 'COLUMN_TYPE' => 'tinyint(1)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'superperm' => array ( 'TABLE_NAME' => 'user', 'COLUMN_NAME' => 'superPerm', 'COLUMN_TYPE' => 'tinyint(1)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'comment' => array ( 'TABLE_NAME' => 'user', 'COLUMN_NAME' => 'comment', 'COLUMN_TYPE' => 'text', 'DATA_TYPE' => 'text', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '65535', 'CHARACTER_OCTET_LENGTH' => '65535', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
      ),
      'INDICES' => array (
        'logonname' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'logonName', 'INDEX_KEY_TYPE' => 'UNIQUE', 'TABLE_NAME' => 'user',  ),
          'INDEX_COLUMNS' => array (
            'logonname' => array ( 'TABLE_NAME' => 'user', 'INDEX_NAME' => 'logonName', 'COLUMN_NAME' => 'logonName', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'user',  ),
          'INDEX_COLUMNS' => array (
            'userid' => array ( 'TABLE_NAME' => 'user', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'userId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
    ),
    'usergroup' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'userGroup', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'usergroupid' => array ( 'TABLE_NAME' => 'userGroup', 'COLUMN_NAME' => 'userGroupId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI', 'EXTRA' => 'auto_increment',  ),
        'name' => array ( 'TABLE_NAME' => 'userGroup', 'COLUMN_NAME' => 'name', 'COLUMN_TYPE' => 'varchar(250)', 'DATA_TYPE' => 'varchar', 'IS_NULLABLE' => 'NO', 'CHARACTER_MAXIMUM_LENGTH' => '250', 'CHARACTER_OCTET_LENGTH' => '750', 'CHARACTER_SET_NAME' => 'utf8', 'COLLATION_NAME' => 'utf8_unicode_ci',  ),
        'updatemasterdataperm' => array ( 'TABLE_NAME' => 'userGroup', 'COLUMN_NAME' => 'updateMasterDataPerm', 'COLUMN_TYPE' => 'tinyint(4)', 'DATA_TYPE' => 'tinyint', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '3', 'NUMERIC_SCALE' => '0',  ),
        'insertbookingperm' => array ( 'TABLE_NAME' => 'userGroup', 'COLUMN_NAME' => 'insertBookingPerm', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
        'updatebookingperm' => array ( 'TABLE_NAME' => 'userGroup', 'COLUMN_NAME' => 'updateBookingPerm', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0',  ),
      ),
      'INDICES' => array (
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'userGroup',  ),
          'INDEX_COLUMNS' => array (
            'usergroupid' => array ( 'TABLE_NAME' => 'userGroup', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'userGroupId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
      ),
    ),
    'usertousergroup' => array (
      'TABLE_META' => array ( 'TABLE_NAME' => 'userToUserGroup', 'ENGINE' => 'InnoDB', 'TABLE_COLLATION' => 'utf8_unicode_ci',  ),
      'COLUMNS' => array (
        'userid' => array ( 'TABLE_NAME' => 'userToUserGroup', 'COLUMN_NAME' => 'userId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
        'usergroupid' => array ( 'TABLE_NAME' => 'userToUserGroup', 'COLUMN_NAME' => 'userGroupId', 'COLUMN_TYPE' => 'int(11)', 'DATA_TYPE' => 'int', 'IS_NULLABLE' => 'NO', 'NUMERIC_PRECISION' => '10', 'NUMERIC_SCALE' => '0', 'COLUMN_KEY' => 'PRI',  ),
      ),
      'INDICES' => array (
        'primary' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'PRIMARY', 'INDEX_KEY_TYPE' => 'PRIMARY', 'TABLE_NAME' => 'userToUserGroup',  ),
          'INDEX_COLUMNS' => array (
            'userid' => array ( 'TABLE_NAME' => 'userToUserGroup', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'userId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
            'usergroupid' => array ( 'TABLE_NAME' => 'userToUserGroup', 'INDEX_NAME' => 'PRIMARY', 'COLUMN_NAME' => 'userGroupId', 'NON_UNIQUE' => '0', 'UNIQUE' => '1',  ),
          ),
        ),
        'usergroupid' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'userGroupId', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'userToUserGroup',  ),
          'INDEX_COLUMNS' => array (
            'usergroupid' => array ( 'TABLE_NAME' => 'userToUserGroup', 'INDEX_NAME' => 'userGroupId', 'COLUMN_NAME' => 'userGroupId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
        'userid' => array (
          'INDEX_META' => array ( 'INDEX_NAME' => 'userId', 'INDEX_KEY_TYPE' => '', 'TABLE_NAME' => 'userToUserGroup',  ),
          'INDEX_COLUMNS' => array (
            'userid' => array ( 'TABLE_NAME' => 'userToUserGroup', 'INDEX_NAME' => 'userId', 'COLUMN_NAME' => 'userId', 'NON_UNIQUE' => '1', 'UNIQUE' => '0',  ),
          ),
        ),
      ),
    ),
  ),
)

;
?>
