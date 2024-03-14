<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("buttons.inc.php");
        use_unit("actnlist.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class MyFirstI18n extends Page
        {
                public $lblResName = null;
                public $lblResFirstname = null;
                public $lblRes = null;
                public $Image1 = null;
                public $btnSelLang=null;
                public $cmbBxSelLang=null;
                public $lblSelLang=null;
                public $btnEnter=null;
                public $edtName=null;
                public $lblName=null;
                public $edtFirstName=null;
                public $lblFirstName=null;
                public $lblTitle=null;
                public $lblMainTitle=null;

                function btnEnterClick($sender, $params)
                {
                        $formvars = array();
                        foreach($_REQUEST as $key => $value)
                        {
                                $formvars[$key] .= $value;
                        }
                        $this->lblResFirstname->Caption = $formvars['edtFirstName'];
                        $this->lblResName->Caption = $formvars['edtName'];
                        // make labels visible
                        $this->lblRes->Visible = true;
                        $this->lblResFirstname->Visible = true;
                        $this->lblResName->Visible = true;
                }

                function btnSelLangClick($sender, $params)
                {
                        $lang;
                        switch($_REQUEST['cmbBxSelLang'])
                        {
                                case 'en': $lang = 'English (United States)'; break;
                                case 'de': $lang = 'German (Germany)'; break;
                                case 'fr': $lang = 'French (France)'; break;
                                case 'es': $lang = 'Spanish (Traditional Sort)'; break;
                                default: $lang = 'English (United States)';
                        }
                        $this->Language = $lang;
                }
}

        global $application;

        global $MyFirstI18n;

        //Creates the form
        $MyFirstI18n=new MyFirstI18n($application);

        //Read from resource file
        $MyFirstI18n->loadResource(__FILE__);

        //Shows the form
        $MyFirstI18n->show();

?>
