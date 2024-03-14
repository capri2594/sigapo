<?php 
header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Guia Telefonica</title>
<!-- framework.. -->
<link rel="stylesheet" type="text/css" href="lib/ext-2.2/resources/css/ext-all.css" />
<!-- 
<link rel="stylesheet" type="text/css" href="lib/ext-2.2/resources/css/xtheme-olive.css" />-->
<script type="text/javascript" src="lib/ext-2.2/adapter/prototype/prototype-1.5.1.2.js"> </script>
<script type="text/javascript" src="lib/ext-2.2/adapter/prototype/ext-prototype-adapter.js">
</script>
<script type="text/javascript" src="lib/ext-2.2/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="lib/ext-2.2/ext-all.js"></script>
<script type="text/javascript" src="lib/ext-2.2/source/locale/ext-lang-es.js">
</script>
<!-- fin framworks -->
<script type="text/javascript">
function agenda(){
Ext.BLANK_IMAGE_URL = 'lib/ext-2.2/resources/images/default/s.gif';
   //
   // Creamos el registro de datos
   //
//Ext.onReady(function(){

	var categoriesRecord = new Ext.data.Record.create([
    	{name: 'cod', type: 'string'},
        {name: 'nombredep', type: 'string'},
        {name: 'fono1', type: 'string'},
        {name: 'fono2', type: 'string'},
        {name: 'fax', type: 'string'},
		{name: 'sigla', type: 'string'}
		
    ]);
		   //
    // Creamos el reader de datos
     //
    var categoriesGridReader = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'nombredep'},
        categoriesRecord
    );
	   //
     // Creamos el proxy para lectura remota de datos
    //
    var categoriesDataProxy = new Ext.data.HttpProxy({
        url: 'fonos_uo_json.php',   // Servicio web
        method: 'POST'                          // Método de envío
    });
	    //
     // Creamos el datastore donde se van a almacenar los datos de la tabla
     //
    var categoriesDataStore = new Ext.data.Store({
        id: 'categoriesDS',
        //Indicamos de donde se va a leer los datos, en este caso un servicio web
        proxy: categoriesDataProxy,
        // Parámetros base que se enviarán al script
        baseParams: {
            language: "es_ES"
        },
        // Indicamos el reader, es decir el procesador de los datos
        reader: categoriesGridReader
    });
	
	    var categoriesColumnMode = new Ext.grid.ColumnModel(
        [new Ext.grid.RowNumberer(),
		{
            header: 'Nombre de la Oficina',
            dataIndex: 'nombredep',
            width: 380,
			sortable: true,
            hidden: false
        },
		{
            header: 'Sigla',
            dataIndex: 'cod',
            width: 120
            
        },
		{
            header: 'Telefono1',
            dataIndex: 'fono1',
            width: 80
        },{
            header: 'Telefono2',
            dataIndex: 'fono2',
            width: 80
        },{
            header: 'Fax',
            dataIndex: 'fax',
            width: 80
            
        }]
    );
	    var categoriesGrid = new Ext.grid.GridPanel({
        id: 'cat_categoriesGrid',
        store: categoriesDataStore,
        cm: categoriesColumnMode,
        enableColLock:false,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
		width:840,//renderTo: example-grid,
        height:543,
		listeners: {rowclick: function() {
		  //alert('doble click');
		 //alert('total:'+ this.store.getCount()); //muestra el total de los registros
		 code=this.getSelectionModel().getSelected().get('cod');//recuperar campo cod
		 categoriesDataStore2.load({params: {start: 0, limit: 10, id: code }});
		 //derecho.title('Funcionarios-'+code);
		//Ext.Msg.alert('Test','Oficina: '+record.get('nombredep')); //alert temporal 
		}
		//,rowcontextmenu: function() {alert('menu contextual bloqueado')}
      }
    });

    categoriesDataStore.load();
	//categoriesDataStore.load({params: {start: 0, limit: 10}}); 
	
//grid para ver funcionarios...
	var categoriesRecord2 = new Ext.data.Record.create([
    	{name: 'nombre', type: 'string'},
        {name: 'celular', type: 'string'},
        {name: 'telefono', type: 'string'},
        {name: 'email', type: 'string'},
        {name: 'cargo', type: 'string'}
    ]);
		   //
    // Creamos el reader de datos
     //
    var categoriesGridReader2 = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'nombre'},
        categoriesRecord2
    );
	   //
     // Creamos el proxy para lectura remota de datos
    //
    var categoriesDataProxy2 = new Ext.data.HttpProxy({
        url: 'fonos_uo_funcionarios_json.php',   // Servicio web
        method: 'POST'                          // Método de envío
    });
	    //
     // Creamos el datastore donde se van a almacenar los datos de la tabla
     //
    var categoriesDataStore2 = new Ext.data.Store({
        id: 'categoriesDS2',
        //Indicamos de donde se va a leer los datos, en este caso un servicio web
        proxy: categoriesDataProxy2,
        // Parámetros base que se enviarán al script
        baseParams: {
            language: "es_ES"
        },
        // Indicamos el reader, es decir el procesador de los datos
        reader: categoriesGridReader2
    });
	
	    var categoriesColumnMode2 = new Ext.grid.ColumnModel(
        [new Ext.grid.RowNumberer(),
		{
            header: 'Nombre Funcionario',
            dataIndex: 'nombre',
            width: 150,
			sortable: true,
            hidden: false
        },{
            header: 'Celular',
            dataIndex: 'celular',
            width: 80
        },{
            header: 'Telefono',
            dataIndex: 'telefono',
            width: 80
        },{
            header: 'email',
            dataIndex: 'email',
            width: 100
            
        }]
    );
	    var categoriesGrid2 = new Ext.grid.GridPanel({
        id: 'cat_categoriesGrid2',
        store: categoriesDataStore2,
        cm: categoriesColumnMode2,
        enableColLock:false,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
		width:430,//renderTo: example-grid,
        height:543/*,
		listeners: {rowclick: function() {
		//alert('doble click');
		 //alert('total:'+ this.store.getCount());
		 //alert('total:'+ this.store.getSelected());
		 alert(this.getSelectionModel().getSelected().get('nombre'));
		//var record=categoriesGrid.getStore().getAt(index); 
		//Ext.Msg.alert('Test','Oficina: '+record.get('nombredep')); //alert temporal 
		}
		//,rowcontextmenu: function() {alert('menu contextual bloqueado')}
      }*/
    });
//fin grid funcionarios
function filtrar(){
    categoriesDataProxy.url='fonos_uo_json_filtro.php';
    //categoriesDataStore.load();
	categoriesDataStore.load({params: {start: 0, limit: 10, txt:$('nomdep_id').value}});
}

//diseñando el panel

//esto es para modificar a tu antojo...
Ext.onReady(function() {
	/**
	 * Panel principal, con layout border
	 */
	var buscar =new Ext.Panel({
        	//
        	// Panel con layout 'form'
        	//
            region: 'west',
            collapsible: true,
            title: 'Busqueda',
            xtype: 'panel',
            layout: 'form',
            width: 200,
            minWidth: 300,
			margins: '0 0 10 0',
			cmargins: '5 5 0 0',
			bodyStyle: 'padding:5px',
            autoScroll: true,
            split: true,
			labelWidth : 40,
            items: [{
                    xtype: 'hidden',
                    id: 'gal_id_hidden',
                    name: 'gal_id'
                },{
                    xtype: 'textfield',
					id: 'nomdep_id',
                    name: 'nomdep',
                    anchor: '98%',
                    fieldLabel: 'Oficina',
					allowBlank:false,
                }
            ],
            buttons:[{
                text: 'Buscar',
				iconCls: 'icon-buscar',
				//tooltip:'Llene el cajon de texto',
				handler: function(btn, pressed){
				//alert('presionaste click: '+$('nomdep_id').value);
				filtrar();
				}
			},
            {
                text: 'Cancelar'
				
            }],
			keys: [
	            { key: [Ext.EventObject.ENTER], handler: function() {
	                    //Ext.Msg.alert("Alert","Enter Key Event !");
						filtrar();
	                }
	            }
	        ]
        });
	var guia = new Ext.Panel({
        	/*
        	 * Panel tipo accordion
        	 */
			 
			title: 'Oficinas y sus Telefonos',
            region: 'center',
            xtype: 'panel',
			width: 300,
			items: [categoriesGrid]            
        });	
	var derecho = new Ext.Panel({
        	/*
             * Panel con layout 'fit'
             */
            region: 'east',
            collapsible: true,
            title: 'Funcionarios',
            xtype: 'panel',
            layout: 'fit',
            width: 300,
            items: [
			 /*{
            	//
                // Panel con layout 'column'
                //
            	xtype: 'panel',
                layout:'column',
                items: [{
                    title: 'Nombre',
                    columnWidth: .666
                },{
                    title: 'Celular',
                    columnWidth: .333
                }]
            }*/
			categoriesGrid2
			]
        });	
    var backendViewport = new Ext.Panel({
    	layout: 'border',
        renderTo: 'divRender',
        //width: 800,
		anchor:'100%',
        height: 600,
        items: [{
            region: 'north',
            xtype: 'panel',
            autoHeight: true,
            border: false,
            margins: '0 0 2 0',
            html: '<div class="x-panel-header"><center>Guia de Telefonos</center></div>'
        },guia,buscar,derecho]	     
    });
});

}
//});
	
function bloqueado(){
     Ext.Msg.alert('Alerta','Esta guia aun esta en proceso de elaboracion, GRACIAS');	 
}
</script>
<style>

h1 {
    background: #7F99BE url(imagen/layout-browser-hd-bg.gif) repeat-x center;
	font-size: 16px;
    color: #fff;
    font-weight: normal;
    padding: 5px 10px;
}
body{
background: #7F99BE;
}
.icon-buscar{background:transparent url(icons/btn_icon_search.png) 0 0 no-repeat !important;}  
</style>
</head>

<body onload="agenda();">
<h1>GOBIERNO AUTONOMO DEPARTAMENTAL DE ORURO</h1>
<div id="example-grid"></div>
<div id="divRender"></div>
</body>
</html>