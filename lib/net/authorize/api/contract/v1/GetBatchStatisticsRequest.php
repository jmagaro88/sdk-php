<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing GetBatchStatisticsRequest
 */
class GetBatchStatisticsRequest extends ANetApiRequestType
{

    /**
     * @property string $batchId
     */
    private $batchId = null;

    /**
     * Gets as batchId
     *
     * @return string
     */
    public function getBatchId()
    {
        return $this->batchId;
    }

    /**
     * Sets a new batchId
     *
     * @param string $batchId
     * @return self
     */
    public function setBatchId($batchId)
    {
        $this->batchId = $batchId;
        return $this;
    }


    // Json Serialize Code
    public function jsonSerialize(){
        $values = array_filter((array)get_object_vars($this),
        function ($val){
            return !is_null($val);
        });
        $mapper = \net\authorize\util\Mapper::Instance();
        // echo __CLASS__ . "\n";
        foreach($values as $key => $value){
            $classDetails = $mapper->getClass(get_class() , $key);
            if (isset($value)){
                //$classDetails = (new \net\authorize\api\contract\v1\Mapper)->getClass(get_class() , $key);
                if ($classDetails->className === 'Date'){
                    $dateTime = $value->format('Y-m-d');
                    $values[$key] = $dateTime;
                    //echo($dateTime."\n");
                }
                else if ($classDetails->className === 'DateTime'){
                    $dateTime = $value->format('Y-m-d\TH:i:s\Z');
                    $values[$key] = $dateTime;
                    //echo($dateTime."\n");
                }
                if (is_array($value)){

                    //echo "key - $key \n";
                    //echo "value - $value \n";
                    if (!$classDetails->isInlineArray){
                        $subKey = $classDetails->arrayEntryname;
                        $subArray = [$subKey => $value];
                        $values[$key] = $subArray;
                        //echo "subkey - $subKey \n";
                    }
                }
            }
        }
        if (get_parent_class() == ""){
            return $values;
        }
        else{
            return array_merge(parent::jsonSerialize(), $values);
        }
    }

}

