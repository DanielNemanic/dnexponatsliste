<?php
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']=array (
	'_DEFAULT' =>
		array (

			'postVarSets' => 
				array(
					'_DEFAULT' => 
						array(

                            //Exponatsliste
                            'ExponatC' =>
                                array(
                                  array(
                                      'GETvar' => 'tx_dnexponatsliste_dnexponatsliste[controller]'
                                  ),
                                ),
                            'ExponatA' =>
                                array(
                                    array(
                                        'GETvar' => 'tx_dnexponatsliste_dnexponatsliste[action]'
                                    ),
                                ),


							//cHash
							'cHash' =>
								array(							
									array(
										'GETvar' => 'cHash'
									),	
								),					
						),
				),			
	),			
);
?>