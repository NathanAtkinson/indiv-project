<?php

abstract class CustomModel extends Model {

    use ModelUtils;

    protected function validateId($id) { return $id; }

	public function __construct($id = null) {

        //when value given work on customer otherwise do nothing
        if ($id)  {
            if (is_array($id)) {

                //when id for table is being worked with 
                //call the update method
                if (@$id[$this->get_table_id()] &&
                        method_exists($this, 'update')) {
                    $id = $this->update($id);
                    parent::__construct($id);

                //when no table id is given call the insert method
                } else if (method_exists($this, 'insert')) {
                    $id = $this->insert($id);
                    parent::__construct($id);
                }
            }

            //otherwise get the record with value of $id
            if ($this->validateId($id)) {
              parent::__construct($id);
            };
        }
	}

}
