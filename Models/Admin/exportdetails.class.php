<?php
include_once("bean.config.php");

/**
 * Class BeanExportDetails
 * Bean class for object oriented management of the MySQL table export_details
 *
 * Comment of the managed table export_details: Not specified.
 *
 * Responsibility:
 *
 *  - provides instance constructors for both managing of a fetched table or for a new row
 *  - provides destructor to automatically close database connection
 *  - defines a set of attributes corresponding to the table fields
 *  - provides setter and getter methods for each attribute
 *  - provides OO methods for simplify DML select, insert, update and delete operations.
 *  - provides a facility for quickly updating a previously fetched row
 *  - provides useful methods to obtain table DDL and the last executed SQL statement
 *  - provides error handling of SQL statement
 *  - uses Camel/Pascal case naming convention for Attributes/Class used for mapping of Fields/Table
 *  - provides useful PHPDOC information about the table, fields, class, attributes and methods.
 *
 * @extends MySqlRecord
 * @filesource BeanExportDetails.php
 * @category MySql Database Bean Class
 * @package beans
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @note  This is an auto generated PHP class builded with MVCMySqlReflection, a small code generation engine extracted from the author's personal MVC Framework.
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD Public License.
*/

// namespace beans;

class BeanExportDetails extends MySqlRecord
{
    /**
     * A control attribute for the update operation.
     * @note An instance fetched from db is allowed to run the update operation.
     *       A new instance (not fetched from db) is allowed only to run the insert operation but,
     *       after running insertion, the instance is automatically allowed to run update operation.
     * @var bool
     */
    private $allowUpdate = false;

    /**
     * Class attribute for mapping the primary key id_export of table export_details
     *
     * Comment for field id_export: Not specified<br>
     * @var int $idExport
     */
    private $idExport;

    /**
     * A class attribute for evaluating if the table has an autoincrement primary key
     * @var bool $isPkAutoIncrement
     */
    private $isPkAutoIncrement = true;

    /**
     * Class attribute for mapping table field op_id
     *
     * Comment for field op_id: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var int $opId
     */
    private $opId;

    /**
     * Class attribute for mapping table field out_date
     *
     * Comment for field out_date: Not specified.<br>
     * Field information:
     *  - Data type: string|date
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $outDate
     */
    private $outDate;

    /**
     * Class attribute for mapping table field back_date
     *
     * Comment for field back_date: Not specified.<br>
     * Field information:
     *  - Data type: string|date
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $backDate
     */
    private $backDate;

    /**
     * Class attribute for mapping table field postponed
     *
     * Comment for field postponed: Not specified.<br>
     * Field information:
     *  - Data type: bit(1)
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var null $postponed
     */
    private $postponed;

    /**
     * Class attribute for mapping table field postponed_date
     *
     * Comment for field postponed_date: Not specified.<br>
     * Field information:
     *  - Data type: datetime
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $postponedDate
     */
    private $postponedDate;

    /**
     * Class attribute for mapping table field itinary
     *
     * Comment for field itinary: Not specified.<br>
     * Field information:
     *  - Data type: text
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $itinary
     */
    private $itinary;

    /**
     * Class attribute for mapping table field comment
     *
     * Comment for field comment: Not specified.<br>
     * Field information:
     *  - Data type: text
     *  - Null : YES
     *  - DB Index: 
     *  - Default: 
     *  - Extra:  
     * @var string $comment
     */
    private $comment;

    /**
     * Class attribute for mapping table field voiture_id
     *
     * Comment for field voiture_id: Not specified.<br>
     * Field information:
     *  - Data type: int(11)
     *  - Null : NO
     *  - DB Index: MUL
     *  - Default: 
     *  - Extra:  
     * @var int $voitureId
     */
    private $voitureId;

    /**
     * Class attribute for storing the SQL DDL of table export_details
     * @var string base64 encoded string for DDL
     */
    private $ddl = "Q1JFQVRFIFRBQkxFIGBleHBvcnRfZGV0YWlsc2AgKAogIGBpZF9leHBvcnRgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsCiAgYG9wX2lkYCBpbnQoMTEpIE5PVCBOVUxMLAogIGBvdXRfZGF0ZWAgZGF0ZSBERUZBVUxUIE5VTEwsCiAgYGJhY2tfZGF0ZWAgZGF0ZSBERUZBVUxUIE5VTEwsCiAgYHBvc3Rwb25lZGAgYml0KDEpIERFRkFVTFQgTlVMTCwKICBgcG9zdHBvbmVkX2RhdGVgIGRhdGV0aW1lIERFRkFVTFQgTlVMTCwKICBgaXRpbmFyeWAgdGV4dCwKICBgY29tbWVudGAgdGV4dCwKICBgdm9pdHVyZV9pZGAgaW50KDExKSBOT1QgTlVMTCwKICBQUklNQVJZIEtFWSAoYGlkX2V4cG9ydGApLAogIEtFWSBgb3BfaWRgIChgb3BfaWRgKSwKICBLRVkgYHZvaXR1cmVfaWRgIChgdm9pdHVyZV9pZGApCikgRU5HSU5FPU15SVNBTSBERUZBVUxUIENIQVJTRVQ9bGF0aW4x";

    /**
     * setIdExport Sets the class attribute idExport with a given value
     *
     * The attribute idExport maps the field id_export defined as int(11).<br>
     * Comment for field id_export: Not specified.<br>
     * @param int $idExport
     * @category Modifier
     */
    public function setIdExport($idExport)
    {
        $this->idExport = (int)$idExport;
    }

    /**
     * setOpId Sets the class attribute opId with a given value
     *
     * The attribute opId maps the field op_id defined as int(11).<br>
     * Comment for field op_id: Not specified.<br>
     * @param int $opId
     * @category Modifier
     */
    public function setOpId($opId)
    {
        $this->opId = (int)$opId;
    }

    /**
     * setOutDate Sets the class attribute outDate with a given value
     *
     * The attribute outDate maps the field out_date defined as string|date.<br>
     * Comment for field out_date: Not specified.<br>
     * @param string $outDate
     * @category Modifier
     */
    public function setOutDate($outDate)
    {
        $this->outDate = (string)$outDate;
    }

    /**
     * setBackDate Sets the class attribute backDate with a given value
     *
     * The attribute backDate maps the field back_date defined as string|date.<br>
     * Comment for field back_date: Not specified.<br>
     * @param string $backDate
     * @category Modifier
     */
    public function setBackDate($backDate)
    {
        $this->backDate = (string)$backDate;
    }

    /**
     * setPostponed Sets the class attribute postponed with a given value
     *
     * The attribute postponed maps the field postponed defined as bit(1).<br>
     * Comment for field postponed: Not specified.<br>
     * @param null $postponed
     * @category Modifier
     */
    public function setPostponed($postponed)
    {
        $this->postponed = (string)$postponed;
    }

    /**
     * setPostponedDate Sets the class attribute postponedDate with a given value
     *
     * The attribute postponedDate maps the field postponed_date defined as datetime.<br>
     * Comment for field postponed_date: Not specified.<br>
     * @param string $postponedDate
     * @category Modifier
     */
    public function setPostponedDate($postponedDate)
    {
        $this->postponedDate = (string)$postponedDate;
    }

    /**
     * setItinary Sets the class attribute itinary with a given value
     *
     * The attribute itinary maps the field itinary defined as text.<br>
     * Comment for field itinary: Not specified.<br>
     * @param string $itinary
     * @category Modifier
     */
    public function setItinary($itinary)
    {
        $this->itinary = (string)$itinary;
    }

    /**
     * setComment Sets the class attribute comment with a given value
     *
     * The attribute comment maps the field comment defined as text.<br>
     * Comment for field comment: Not specified.<br>
     * @param string $comment
     * @category Modifier
     */
    public function setComment($comment)
    {
        $this->comment = (string)$comment;
    }

    /**
     * setVoitureId Sets the class attribute voitureId with a given value
     *
     * The attribute voitureId maps the field voiture_id defined as int(11).<br>
     * Comment for field voiture_id: Not specified.<br>
     * @param int $voitureId
     * @category Modifier
     */
    public function setVoitureId($voitureId)
    {
        $this->voitureId = (int)$voitureId;
    }

    /**
     * getIdExport gets the class attribute idExport value
     *
     * The attribute idExport maps the field id_export defined as int(11).<br>
     * Comment for field id_export: Not specified.
     * @return int $idExport
     * @category Accessor of $idExport
     */
    public function getIdExport()
    {
        return $this->idExport;
    }

    /**
     * getOpId gets the class attribute opId value
     *
     * The attribute opId maps the field op_id defined as int(11).<br>
     * Comment for field op_id: Not specified.
     * @return int $opId
     * @category Accessor of $opId
     */
    public function getOpId()
    {
        return $this->opId;
    }

    /**
     * getOutDate gets the class attribute outDate value
     *
     * The attribute outDate maps the field out_date defined as string|date.<br>
     * Comment for field out_date: Not specified.
     * @return string $outDate
     * @category Accessor of $outDate
     */
    public function getOutDate()
    {
        return $this->outDate;
    }

    /**
     * getBackDate gets the class attribute backDate value
     *
     * The attribute backDate maps the field back_date defined as string|date.<br>
     * Comment for field back_date: Not specified.
     * @return string $backDate
     * @category Accessor of $backDate
     */
    public function getBackDate()
    {
        return $this->backDate;
    }

    /**
     * getPostponed gets the class attribute postponed value
     *
     * The attribute postponed maps the field postponed defined as bit(1).<br>
     * Comment for field postponed: Not specified.
     * @return null $postponed
     * @category Accessor of $postponed
     */
    public function getPostponed()
    {
        return $this->postponed;
    }

    /**
     * getPostponedDate gets the class attribute postponedDate value
     *
     * The attribute postponedDate maps the field postponed_date defined as datetime.<br>
     * Comment for field postponed_date: Not specified.
     * @return string $postponedDate
     * @category Accessor of $postponedDate
     */
    public function getPostponedDate()
    {
        return $this->postponedDate;
    }

    /**
     * getItinary gets the class attribute itinary value
     *
     * The attribute itinary maps the field itinary defined as text.<br>
     * Comment for field itinary: Not specified.
     * @return string $itinary
     * @category Accessor of $itinary
     */
    public function getItinary()
    {
        return $this->itinary;
    }

    /**
     * getComment gets the class attribute comment value
     *
     * The attribute comment maps the field comment defined as text.<br>
     * Comment for field comment: Not specified.
     * @return string $comment
     * @category Accessor of $comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * getVoitureId gets the class attribute voitureId value
     *
     * The attribute voitureId maps the field voiture_id defined as int(11).<br>
     * Comment for field voiture_id: Not specified.
     * @return int $voitureId
     * @category Accessor of $voitureId
     */
    public function getVoitureId()
    {
        return $this->voitureId;
    }

    /**
     * Gets DDL SQL code of the table export_details
     * @return string
     * @category Accessor
     */
    public function getDdl()
    {
        return base64_decode($this->ddl);
    }

    /**
    * Gets the name of the managed table
    * @return string
    * @category Accessor
    */
    public function getTableName()
    {
        return "export_details";
    }

    /**
     * The BeanExportDetails constructor
     *
     * It creates and initializes an object in two way:
     *  - with null (not fetched) data if none $idExport is given.
     *  - with a fetched data row from the table export_details having id_export=$idExport
     * @param int $idExport. If omitted an empty (not fetched) instance is created.
     * @return BeanExportDetails Object
     */
    public function __construct($idExport = null)
    {
        parent::__construct();
        if (!empty($idExport)) {
            $this->select($idExport);
        }
    }

    /**
     * The implicit destructor
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Explicit destructor. It calls the implicit destructor automatically.
     */
    public function close()
    {
        unset($this);
    }

    /**
     * Fetchs a table row of export_details into the object.
     *
     * Fetched table fields values are assigned to class attributes and they can be managed by using
     * the accessors/modifiers methods of the class.
     * @param int $idExport the primary key id_export value of table export_details which identifies the row to select.
     * @return int affected selected row
     * @category DML
     */
    public function select($idExport)
    {
        $sql =  "SELECT * FROM export_details WHERE id_export={$this->parseValue($idExport,'int')}";
        $this->resetLastSqlError();
        $result =  $this->query($sql);
        $this->resultSet=$result;
        $this->lastSql = $sql;
        if ($result){
            $rowObject = $result->fetch_object();
            @$this->idExport = (integer)$rowObject->id_export;
            @$this->opId = (integer)$rowObject->op_id;
            @$this->outDate = empty($rowObject->out_date) ? null : date(FETCHED_DATE_FORMAT,strtotime($rowObject->out_date));
            @$this->backDate = empty($rowObject->back_date) ? null : date(FETCHED_DATE_FORMAT,strtotime($rowObject->back_date));
            @$this->postponed = $rowObject->postponed;
            @$this->postponedDate = empty($rowObject->postponed_date) ? null : date(FETCHED_DATETIME_FORMAT,strtotime($rowObject->postponed_date));
            @$this->itinary = $this->replaceAposBackSlash($rowObject->itinary);
            @$this->comment = $this->replaceAposBackSlash($rowObject->comment);
            @$this->voitureId = (integer)$rowObject->voiture_id;
            $this->allowUpdate = true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Deletes a specific row from the table export_details
     * @param int $idExport the primary key id_export value of table export_details which identifies the row to delete.
     * @return int affected deleted row
     * @category DML
     */
    public function delete($idExport)
    {
        $sql = "DELETE FROM export_details WHERE id_export={$this->parseValue($idExport,'int')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        }
        return $this->affected_rows;
    }

    /**
     * Insert the current object into a new table row of export_details
     *
     * All class attributes values defined for mapping all table fields are automatically used during inserting
     * @return mixed MySQL insert result
     * @category DML
     */
    public function insert()
    {
        if ($this->isPkAutoIncrement) {
            $this->idExport = "";
        }
        // $constants = get_defined_constants();
        $sql = <<< SQL
            INSERT INTO export_details
            (op_id,out_date,back_date,postponed,postponed_date,itinary,comment,voiture_id)
            VALUES(
			{$this->parseValue($this->opId)},
			{$this->parseValue($this->outDate,'date')},
			{$this->parseValue($this->backDate,'date')},
			{$this->parseValue($this->postponed,'notNumber')},
			{$this->parseValue($this->postponedDate,'datetime')},
			{$this->parseValue($this->itinary,'notNumber')},
			{$this->parseValue($this->comment,'notNumber')},
			{$this->parseValue($this->voitureId)})
SQL;
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->lastSql = $sql;
        if (!$result) {
            $this->lastSqlError = $this->sqlstate . " - ". $this->error;
        } else {
            $this->allowUpdate = true;
            if ($this->isPkAutoIncrement) {
                $this->idExport = $this->insert_id;
            }
        }
        return $result;
    }

    /**
     * Updates a specific row from the table export_details with the values of the current object.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating of selected row.<br>
     * Null values are used for all attributes not previously setted.
     * @param int $idExport the primary key id_export value of table export_details which identifies the row to update.
     * @return mixed MySQL update result
     * @category DML
     */
    public function update($idExport)
    {
        // $constants = get_defined_constants();
        if ($this->allowUpdate) {
            $sql = <<< SQL
            UPDATE
                export_details
            SET 
				op_id={$this->parseValue($this->opId)},
				out_date={$this->parseValue($this->outDate,'date')},
				back_date={$this->parseValue($this->backDate,'date')},
				postponed={$this->parseValue($this->postponed,'notNumber')},
				postponed_date={$this->parseValue($this->postponedDate,'datetime')},
				itinary={$this->parseValue($this->itinary,'notNumber')},
				comment={$this->parseValue($this->comment,'notNumber')},
				voiture_id={$this->parseValue($this->voitureId)}
            WHERE
                id_export={$this->parseValue($idExport,'int')}
SQL;
            $this->resetLastSqlError();
            $result = $this->query($sql);
            if (!$result) {
                $this->lastSqlError = $this->sqlstate . " - ". $this->error;
            } else {
                $this->select($idExport);
                $this->lastSql = $sql;
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Facility for updating a row of export_details previously loaded.
     *
     * All class attribute values defined for mapping all table fields are automatically used during updating.
     * @category DML Helper
     * @return mixed MySQLi update result
     */
    public function updateCurrent()
    {
        if ($this->idExport != "") {
            return $this->update($this->idExport);
        } else {
            return false;
        }
    }

}
?>
