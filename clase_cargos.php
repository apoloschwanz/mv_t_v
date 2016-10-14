<?php

	class cargo{
		protected $lista_cargos ;
		public function __construct()
		{
			$this->lista_cargos = array() ;
		}
		public function obtener_lista_cargos($dn,$el)
		{
			if( $dn == 1 and $el == 1)
			{	
				$this->lista_cargos = array() ;
				$this->lista_cargos[] = array( 'nro'=>1 , 'des'=>'DIPUTADOS NACIONALES' ) ;
			}
			elseif ( $dn == 1 and $el == 2)
			{
				$this->lista_cargos = array() ;
				$this->lista_cargos[] = array( 'nro'=>2 , 'des'=>'LEGISLADORES' ) ;
			}	
			return $this->lista_cargos ;
		}
	}

?>
