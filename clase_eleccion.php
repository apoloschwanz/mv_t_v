 <?php
 
	class eleccion
	{
		//
		// Eleccion
		protected $eleccion_numero_default;
		public function __construct()
		{
			$this->eleccion_numero_default = 1 ;
		}
		public function eleccion_numero_default()
		{
			return $this->eleccion_numero_default ;
		}
		public function txt_muestra_seleccion()
		{
			$txt  ='<table>';
			$txt .='<tr>' ;
			$txt .='<td>';
			$txt .= '<button type="submit" name="elecc_1" class="selbut">CARGOS NACIONALES</button>';
			$txt .='</td>';
			$txt .= '</tr>' ;
			//$txt .='<tr>' ;
			//$txt .='<td>';
			//$txt .= '<button type="submit" name="elecc_2" class="selbut">LOCALES</button>';
			//$txt .='</td>';
			//$txt .= '</tr>' ;
			$txt .='</table>';
			return $txt;
		}
	}
 
 ?>
