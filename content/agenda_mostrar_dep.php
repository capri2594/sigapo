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
<script type="text/javascript" src="lib/ext-2.2/adapter/prototype/prototype-1.5.1.2.js"> </script>
<script type="text/javascript" src="lib/ext-2.2/adapter/prototype/ext-prototype-adapter.js"></script>
<script type="text/javascript" src="lib/ext-2.2/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="lib/ext-2.2/ext-all.js"></script>
<script type="text/javascript" src="lib/ext-2.2/source/locale/ext-lang-es.js"></script>
<!-- fin framworks -->
<script type="text/javascript">
function agenda(){
Ext.BLANK_IMAGE_URL = 'lib/ext-2.2/resources/images/default/s.gif';
   //
   // Creamos el registro de datos
   //
	var categoriesRecord = new Ext.data.Record.create([
    	{name: 'cod', type: 'string'},
        {name: 'nombredep', type: 'string'},
        {name: 'fono1', type: 'string'},
        {name: 'fono2', type: 'string'},
        {name: 'fax', type: 'string'},
		{name: 'sigla', type: 'string'}
    ]);
    
    var categoriesGridReader = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'nombredep'},
        categoriesRecord
    );

    var categoriesDataProxy = new Ext.data.HttpProxy({
        url: 'fonos_uo_json.php',
        method: 'POST'
    });

    var categoriesDataStore = new Ext.data.Store({
        id: 'categoriesDS',
        proxy: categoriesDataProxy,
        baseParams: {
            language: "es_ES"
        },
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
		width:840,
        height:543,
		listeners: {rowclick: function() {
		 code=this.getSelectionModel().getSelected().get('cod');
		 categoriesDataStore2.load({params: {start: 0, limit: 10, id: code }});
		}
      }
    });

    categoriesDataStore.load();
	
	var categoriesRecord2 = new Ext.data.Record.create([
    	{name: 'nombre', type: 'string'},
        {name: 'celular', type: 'string'},
        {name: 'telefono', type: 'string'},
        {name: 'email', type: 'string'},
        {name: 'cargo', type: 'string'}
    ]);

    var categoriesGridReader2 = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'nombre'},
        categoriesRecord2
    );

    var categoriesDataProxy2 = new Ext.data.HttpProxy({
        url: 'fonos_uo_funcionarios_json.php',
        method: 'POST'
    });

    var categoriesDataStore2 = new Ext.data.Store({
        id: 'categoriesDS2',
        proxy: categoriesDataProxy2,
        baseParams: {
            language: "es_ES"
        },
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
		width:430,
        height:543
    });

function filtrar(){
    categoriesDataProxy.url='fonos_uo_json_filtro.php';
	categoriesDataStore.load({params: {start: 0, limit: 10, txt:$('nomdep_id').value}});
}

Ext.onReady(function() {
	var buscar =new Ext.Panel({
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
			labelWidth : 65,
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
				handler: function(btn, pressed){
				     filtrar();
				}
			},
            {
                text: 'Cancelar',
                handler: function() {
                     $('nomdep_id').value = '';
                     filtrar();
                }
            }],
			keys: [
	            { key: [Ext.EventObject.ENTER], handler: function() {
						filtrar();
	                }
	            }
	        ]
        });
        
	var guia = new Ext.Panel({
			title: 'Oficinas y sus Telefonos',
            region: 'center',
            xtype: 'panel',
			width: 300,
			items: [categoriesGrid]            
        });	
        
	var derecho = new Ext.Panel({
            region: 'east',
            collapsible: true,
            title: 'Funcionarios',
            xtype: 'panel',
            layout: 'fit',
            width: 300,
            items: [categoriesGrid2]
        });	
        
    var backendViewport = new Ext.Panel({
    	layout: 'border',
        renderTo: 'divRender',
		anchor:'100%',
        height: 600,
        items: [{
            region: 'north',
            xtype: 'panel',
            autoHeight: true,
            border: false,
            margins: '0 0 2 0',
            html: '<div class="x-panel-header" style="background:transparent !important; border:none !important;"><center style="color:#f59e0b; font-size:23px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">Guia de Telefonos</center></div>'
        },guia,buscar,derecho]	     
    });
});

}
</script>
<style>
/* ExtJS Dark Theme Overrides matching lineamientos_sirc.md */
body {
     background-color: #0f172a !important;
     background-image: none !important;
     color: #cbd5e1 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     margin: 15px !important;
}

h1 {
     background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%) !important;
     color: #ffffff !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 14px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     border-radius: 6px !important;
     padding: 10px 14px !important;
     box-shadow: 0 4px 10px rgba(0,0,0,0.3) !important;
     border: none !important;
     margin: 0 0 15px 0 !important;
}

/* Force global text input and button text color to be white */
input, select, textarea, button, .x-form-field {
     color: #ffffff !important;
}

/* Panel Containers */
.x-panel {
     background: transparent !important;
     border-color: rgba(255, 255, 255, 0.08) !important;
}

.x-panel-header {
     background-image: none !important;
     background-color: #1e3a8a !important; /* Premium dark blue header */
     border-color: rgba(255, 255, 255, 0.08) !important;
     color: #ffffff !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding: 8px 12px !important;
}

.x-panel-body {
     background-color: #1e293b !important;
     border-color: rgba(255, 255, 255, 0.08) !important;
     color: #cbd5e1 !important;
}

/* Grid Customization */
.x-grid3 {
     background-color: #1e293b !important;
}

.x-grid3-header {
     background-image: none !important;
     background-color: rgba(15, 23, 42, 0.4) !important;
     border-color: rgba(255, 255, 255, 0.08) !important;
}

.x-grid3-hd-row td {
     color: #94a3b8 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 10px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     border-color: rgba(255, 255, 255, 0.08) !important;
     background: transparent !important;
}

.x-grid3-row {
     background-color: transparent !important;
     border-color: rgba(255, 255, 255, 0.04) !important;
}

.x-grid3-row-alt {
     background-color: rgba(255, 255, 255, 0.02) !important;
}

.x-grid3-row-over {
     background-image: none !important;
     background-color: rgba(255, 255, 255, 0.05) !important;
}

.x-grid3-row-selected {
     background-image: none !important;
     background-color: rgba(37, 99, 235, 0.25) !important;
     border-color: #2563eb !important;
}

.x-grid3-row-selected td {
     color: #ffffff !important;
}

.x-grid3-cell-inner {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 12px !important;
     color: inherit !important;
}

/* High-specificity override for textfields to prevent white bg-gif leakage and dark grey text */
input.x-form-text, 
input.x-form-field, 
.x-form-text, 
.x-form-field,
.x-form-focus {
     background-color: #0f172a !important;
     background-image: none !important;
     border: 1px solid rgba(255, 255, 255, 0.25) !important;
     border-radius: 4px !important;
     color: #ffffff !important; /* Forces typed text to be clean white */
     padding: 6px 10px !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 13px !important;
     box-sizing: border-box !important;
     height: 26px !important;
}

input.x-form-text:focus,
input.x-form-field:focus,
.x-form-focus {
     border-color: #2563eb !important;
     color: #ffffff !important;
     background-color: #0f172a !important;
}

.x-form-item-label {
     color: #94a3b8 !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
}

/* ExtJS Buttons 9-Slice Table Structure Overrides */
/* Clear the default rounded white/blue sprite images on all cells of the button grid */
.x-btn-tl, .x-btn-tr, .x-btn-tc, 
.x-btn-ml, .x-btn-mr, .x-btn-mc, 
.x-btn-bl, .x-btn-br, .x-btn-bc,
.x-btn-left, .x-btn-right, .x-btn-center {
     background-image: none !important;
     background: transparent !important;
     border: none !important;
     padding: 0 !important;
}

.x-btn {
     background: transparent !important;
     border: none !important;
}

.x-panel-btn-td {
     padding: 4px !important;
}

/* Standard Button styling */
.x-panel-btns-ct button,
.x-btn button,
.x-btn-center button,
button.x-btn-text,
.x-btn-focus button,
.x-btn-over button,
.x-btn-click button {
     border: none !important;
     border-radius: 4px !important;
     color: #ffffff !important;
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
     font-size: 11px !important;
     font-weight: 700 !important;
     text-transform: uppercase !important;
     letter-spacing: 0.5px !important;
     padding: 6px 14px !important;
     height: 28px !important;
     cursor: pointer !important;
     display: inline-flex !important;
     align-items: center !important;
     justify-content: center !important;
     transition: all 0.2s ease-in-out !important;
     outline: none !important;
     box-shadow: none !important;
}

.x-btn button:hover {
     transform: translateY(-1px) !important;
}

/* Green gradient for Buscar (first button) */
.x-panel-btns td:first-child button,
.x-panel-btns td:first-child button.x-btn-text,
.x-panel-btns td:first-child .x-btn-over button,
.x-panel-btns td:first-child .x-btn-focus button,
.x-panel-btns table.x-btn:first-of-type button,
.x-panel-btns table.x-btn:first-of-type button.x-btn-text {
     background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
     color: #ffffff !important;
     box-shadow: 0 2px 5px rgba(16, 185, 129, 0.3) !important;
}
.x-panel-btns td:first-child button:hover,
.x-panel-btns table.x-btn:first-of-type button:hover {
     box-shadow: 0 4px 10px rgba(16, 185, 129, 0.4) !important;
}

/* Red gradient for Cancelar (last button) */
.x-panel-btns td:last-child button,
.x-panel-btns td:last-child button.x-btn-text,
.x-panel-btns td:last-child .x-btn-over button,
.x-panel-btns td:last-child .x-btn-focus button,
.x-panel-btns table.x-btn:last-of-type button,
.x-panel-btns table.x-btn:last-of-type button.x-btn-text {
     background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
     color: #ffffff !important;
     box-shadow: 0 2px 5px rgba(239, 68, 68, 0.3) !important;
}
.x-panel-btns td:last-child button:hover,
.x-panel-btns table.x-btn:last-of-type button:hover {
     box-shadow: 0 4px 10px rgba(239, 68, 68, 0.4) !important;
}

/* Remove all outline borders and default blue focus rings */
.x-btn-focus, .x-btn-focus *, .x-btn-over, .x-btn-over * {
     outline: none !important;
     border-color: transparent !important;
}

/* Hide legacy icons search */
.icon-buscar {
     background-image: none !important;
}

/* Layout Splitter Bar */
.x-border-layout-ct {
     background-color: #0f172a !important;
}
.x-layout-split {
     background-color: #0f172a !important;
}
</style>
</head>

<body onload="agenda();">
<h1>GOBIERNO AUTONOMO DEPARTAMENTAL DE ORURO</h1>
<div id="example-grid"></div>
<div id="divRender"></div>
</body>
</html>