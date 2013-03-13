<?php
App::uses('ErdingerAppController', 'Erdinger.Controller');
/**
 * Diagrams Controller
 *
 */
class DiagramsController extends ErdingerAppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

/**
 * index method
 */
    public function index() {
        $data = array();
        $allObjects = App::objects('model');
        foreach($allObjects as $obj) {    
            if($obj != "AppModel") {
                $ModelName = ClassRegistry::init($obj); 
                $schema = $ModelName->schema();
                if($schema) {
                    $data[$obj] = array(
                        'schema' => $schema,
                        'assoc' => array(
                            'hasMany' => $ModelName->hasMany,
                            'hasOne' => $ModelName->hasOne,
                            'belongsTo' => $ModelName->belongsTo,
                            'hasAndBelongsToMany' => $ModelName->hasAndBelongsToMany,
                        ),
                    );
                }
            }  
        }
       $this->set("data", $data);        
    }
}
