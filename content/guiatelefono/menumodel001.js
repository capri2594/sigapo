function menumodel001Show(x, y, mnuname) {
	z_index++;
	var MenuItems = null;
	var miindex= 0;
	var index= z_index;

	MenuItems = new Array();
	miindex=0;
	MenuItems[miindex++] = new LMMenuItemStruct(mnuname + "_MenuItem1",0,0,170,30,0,0,null,0,null,new LMBranch("0","./index.html"),null,null,"./menumodel001/menuitem0.gif","./menumodel001/menuitem0_over.gif",null);
	MenuItems[miindex++] = new LMMenuItemStruct(mnuname + "_MenuItem2",0,30,170,30,0,0,null,0,null,new LMBranch("0","./company.html"),null,null,"./menumodel001/menuitem1.gif","./menumodel001/menuitem1_over.gif",null);
	MenuItems[miindex++] = new LMMenuItemStruct(mnuname + "_MenuItem3",0,60,170,30,0,0,null,0,null,new LMBranch("0","./services.html"),null,null,"./menumodel001/menuitem2.gif","./menumodel001/menuitem2_over.gif",null);
	MenuItems[miindex++] = new LMMenuItemStruct(mnuname + "_MenuItem4",0,90,170,30,0,0,null,0,null,new LMBranch("0","./products.html"),null,null,"./menumodel001/menuitem3.gif","./menumodel001/menuitem3_over.gif",null);
	MenuItems[miindex++] = new LMMenuItemStruct(mnuname + "_MenuItem5",0,120,170,30,0,0,null,0,null,new LMBranch("0","./contact.html"),null,null,"./menumodel001/menuitem4.gif","./menumodel001/menuitem4_over.gif",null);
	var menumodel001_MNU1 = new LMMenu(mnuname,x+0,y+0,170,150,1,0,null,0,null,MenuItems,1);
	LMObjects[objindex++]= menumodel001_MNU1;

	RegisterMainMenu(menumodel001_MNU1);

	ReIndexMenu(menumodel001_MNU1, index);

}
