<?php

	class lista{
		protected $lista ;
		protected $lista_superlistas ;
		public function __construct()
		{
			$this->lista_superlistas = array() ;
			$this->lista = array() ;
		}
		public function obtener_lista_superlistas($dn,$el)
		{
			$this->lista_superlistas = array() ;
			$this->lista_superlistas[] = array( 'nro'=>1 ,
												'lista_nro'=>206 ,
												'des'=>'Partido Biología',
												'color'=>'#e4f2db' ,
												'imagen'=>'./img/ALIANZA_206.jpg') ;
			$this->lista_superlistas[] = array( 'nro'=>2 ,
												'lista_nro'=>104 ,
												'des'=>'Partido de la Historia',
												'color'=>'#ffefcb' ,
												'imagen'=>'./img/ALIANZA_104.jpg') ;
			$this->lista_superlistas[] = array( 'nro'=>3 ,
												'lista_nro'=>401 ,
												'des'=>'Partido de las Artes',
												'color'=>'#f3f3f5' ,
												'imagen'=>'./img/ALIANZA_401.jpg') ;
			//$this->lista_superlistas[] = array( 'nro'=>4 ,
			//									'lista_nro'=>4 ,
			//									'des'=>'Partido de la Literatura',
			//									'color'=>'#86C7B0' ,
			//									'imagen'=>'./img/ALIANZA_pl.jpg') ;
			return $this->lista_superlistas ;
			
		}
		public function obtener_lista($dn,$el,$sl,$cargo)
		{   
			//
			// Nacionales
			if( $dn == 1 and $el == 1 and $sl == 1 and $cargo = 1)
			{	
				$this->lista = array(  'foto'=>'./img/CANDIDATO_11.jpg', 'nro'=>11 ,
												'des'=>'Partido de Ciencia') ;
			}
			elseif( $dn == 1 and $el == 1 and $sl == 2 and $cargo = 1)
			{	
				$this->lista = array(  'foto'=>'./img/CANDIDATO_12.jpg', 'nro'=>12,
												'des'=>'Partido de la Música' ) ;
			}
			elseif( $dn == 1 and $el == 1 and $sl == 3 and $cargo = 1)
			{	
				$this->lista = array(  'foto'=>'./img/CANDIDATO_13.jpg', 'nro'=>13,
												'des'=>'Partido de la Astronomía' ) ;
			}
			elseif( $dn == 1 and $el == 1 and $sl == 4 and $cargo = 1)
			{	
				$this->lista = array(  'foto'=>'./img/CANDIDATO_14.jpg', 'nro'=>14,
												'des'=>'Partido de la Literatura' ) ;
			}
			//
			// Locales
			elseif ( $dn == 1 and $el == 2 and $sl == 1 and $cargo = 2)
			{	
				$this->lista = array(  'foto'=>'./img/CANDIDATO_21.jpg', 'nro'=>21 ,
												'des'=>'Partido de Ciencia') ;
			}
			elseif( $dn == 1 and $el == 2 and $sl == 2 and $cargo = 2)
			{	
				$this->lista = array(  'foto'=>'./img/CANDIDATO_22.jpg' , 'nro'=>22,
												'des'=>'Partido de la Música') ;
			}
			elseif( $dn == 1 and $el == 2 and $sl == 3 and $cargo = 2)
			{	
				$this->lista = array(  'foto'=>'./img/CANDIDATO_23.jpg' , 'nro'=>23,
												'des'=>'Partido de la Astronomía' ) ;
			}	
			elseif( $dn == 1 and $el == 2 and $sl == 4 and $cargo = 2)
			{	
				$this->lista = array(  'foto'=>'./img/CANDIDATO_24.jpg' , 'nro'=>24,
												'des'=>'Partido de la Literatura' ) ;
			}
			else
				$this->lista = array( 'foto'=>' dn= ' .$dn.' el= '.$el.' sl= '.$sl.' cargo='.$cargo );
			return $this->lista ;
		}
		public function lista_completa($dn,$el,$ln)
		{
			$lnk_foto = './img/LISTA_COMPLETA_'.$ln.'.jpg' ;
			$txt = '<table style="background-color: transparent;" >';
			$txt.='<tr>';
			$txt.='<td>';
			//
			$txt .= '<img src="'.$lnk_foto.'" alt="'.$lnk_foto.'" height="28%" width="85%">' ;
			//
			$txt.='</td>';
			$txt.='</tr>';
			$txt.='</table>' ;
			return $txt ;
		}
	}

?>
