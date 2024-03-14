<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Unit3 extends Page
        {
               public $btnResetPanelProperties = null;
               public $Memo2 = null;
               public $edtPanelColor = null;
               public $ckbShowHintsOnPanel = null;
               public $Label3 = null;
               public $btnSetPanelColor = null;
               public $Panel3 = null;
               public $Memo1 = null;
               public $Label2 = null;
               public $Panel2 = null;
               public $ckbShowHint = null;
               public $cmbPageFont = null;
               public $edtPageColor = null;
               public $btnChangePageFont = null;
               public $Edit2 = null;
               public $btnChangePageColor = null;
               public $Label1 = null;
               public $Panel1 = null;
               function btnResetPanelPropertiesClick($sender, $params)
               {
                        $this->Panel3->ParentFont = true;
                        $this->Panel3->ParentColor = true;
                        $this->Panel3->ParentShowHint = true;
                        // uncheck the checkbox not to cause confusions...
                        $this->ckbShowHintsOnPanel->Checked = false;
               }

               function btnSetPanelColorClick($sender, $params)
               {
                        $this->Panel3->Color = $this->edtPanelColor->Text;
               }

               function ckbShowHintsOnPanelClick($sender, $params)
               {
                        $this->Panel3->ShowHint = $this->ckbShowHintsOnPanel->Checked;
               }

               function ckbShowHintClick($sender, $params)
               {
                        $this->ShowHint = $this->ckbShowHint->Checked;
               }

               function btnChangePageFontClick($sender, $params)
               {
                        switch ($this->cmbPageFont->ItemIndex)
                        {
                                case "defaultfont":
                                {
                                        $this->Font->family = "Verdana";
                                        $this->Font->size = "10px";
                                        $this->Font->color="";
                                        $this->Font->weight="";
                                        $this->Font->align="taNone";
                                        $this->Font->style="";
                                        $this->Font->case="";
                                        $this->Font->variant="";
                                        $this->Font->lineheight="";
                                        break;
                                }
                                case "bold": $this->Font->weight = "bold"; break;
                                case "size": $this->Font->size = "14px"; break;
                                case "case": $this->Font->case = caUpperCase; break;
                        }
               }

               function btnChangePageColorClick($sender, $params)
               {
                        $this->Color = $this->edtPageColor->Text;
               }

        }

        global $application;

        global $Unit3;

        //Creates the form
        $Unit3=new Unit3($application);

        //Read from resource file
        $Unit3->loadResource(__FILE__);

        //Shows the form
        $Unit3->show();

?>
