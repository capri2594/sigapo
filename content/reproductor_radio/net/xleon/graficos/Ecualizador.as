/**
* ...
* @author Diego Ponce de Leon
* @version 0.1
*/

class net.xleon.graficos.Ecualizador {
	
	private var scope:MovieClip;
	private var t:Number = 0;
	private var nBarras:Number;
	private var separacion:Number;
	private var __alturaMax:Number = 20;
	private var __alturaMin:Number;
	private var borderColor:Number = null;
	private var barraColor:Number = 0x222222;
	private var anchoBarra:Number = 5;
	
	public function Ecualizador(_scope:MovieClip, _nBarras:Number, _anchoBarra:Number, _separacion:Number ,_start:Boolean, _alturaMax:Number, _borderColor:Number, _barraColor:Number) {
		scope = _scope;
		nBarras = _nBarras;
		separacion = _separacion;
		alturaMax = _alturaMax;
		alturaMin = alturaMax-10;
		if(_borderColor) borderColor = _borderColor;
		if(_barraColor) barraColor = _barraColor;
		if(_anchoBarra) anchoBarra = _anchoBarra;
		if(_start) start();
	}
	public function set alturaMin(altura:Number){
		if(altura > 0)__alturaMin = altura;
		else __alturaMin = 0;
	}
	public function get alturaMin():Number{
		return __alturaMin;
	}
	public function set alturaMax(altura:Number){
		if(altura > 0)__alturaMax = altura;
		else __alturaMax = 0;
	}
	public function get alturaMax():Number{
		return __alturaMax;
	}
	public function start():Void{
		trace(alturaMax+","+alturaMin);
		trace("Ecualizador.start()");
		scope._visible = true;
		var ref:Object = this;
		scope.onEnterFrame = function(){
			ref.t++;
			var barra:MovieClip = ref.scope.createEmptyMovieClip("barra" + ref.t, ref.t);
			if(ref.borderColor)barra.lineStyle(1, ref.borderColor, 20);
			for (var i = 0; i < ref.nBarras; i++) {
				var altura:Number = ref.aleatorioEntre(ref.alturaMin, ref.alturaMax); //int(Math.random() * 10 + 20);
				barra.beginFill(ref.barraColor, 30);
				barra.moveTo((i * ref.separacion), 0);
				barra.lineTo((i * ref.separacion), -altura);
				barra.lineTo((ref.anchoBarra + i * ref.separacion), -altura);
				barra.lineTo((ref.anchoBarra + i * ref.separacion), 0);
				barra.lineTo((i * ref.separacion), 0);
				barra.endFill();
			}
			if (ref.t == 3) ref.t = 0;
		}
	}
	public function stop():Void{
		var alMax:Number = alturaMax;
		var alMin:Number = alturaMin;
		var esclavo:MovieClip = scope.createEmptyMovieClip("esc", -1000);
		var ref:Object = this;
		esclavo.onEnterFrame = function(){
			ref.alturaMax -= 1;
			ref.alturaMin -= 1;
			if(ref.alturaMax == 0 && ref.alturaMin == 0) {
				delete this.onEnterFrame;
				ref.scope.onEnterFrame = null;
				ref.scope._visible = false;
				ref.alturaMax = alMax;
				ref.alturaMin = alMin;
			}
		}
	}
	private function aleatorioEntre(min:Number, max:Number):Number {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}
}
