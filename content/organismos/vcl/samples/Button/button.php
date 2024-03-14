<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class ButtonSample extends Page
        {
                public $Label2 = null;
                public $Label1 = null;
                public $Button11 = null;
                public $Button10 = null;
                public $Button9 = null;
                public $Button8 = null;
                public $Button7 = null;
                public $Memo1 = null;
                public $Button6 = null;
                public $Button5 = null;
                public $Button4 = null;
                public $Button3 = null;
                public $Button2 = null;
                public $Button1 = null;
                function Button7Click($sender, $params)
                {
                        $fontNr = rand(1, 4);
                        $fontAlign = rand(1, 4);
                        $fontSize = rand(9, 16);
                        $fontWeight = rand(0, 1);
                        // get the RGB values for the color
                        $fontColorR = rand(0, 255);
                        $fontColorG = rand(0, 255);
                        $fontColorB = rand(0, 255);

                        switch ($fontNr)
                        {
                                case 1: $this->Button7->Font->Family = "Verdana"; break;
                                case 2: $this->Button7->Font->Family = "Courier"; break;
                                case 3: $this->Button7->Font->Family = "serif"; break;
                                case 4: $this->Button7->Font->Family = "cursive"; break;
                        }
                        switch ($fontAlign)
                        {
                                case 1: $this->Button7->Font->Align = taLeft; break;
                                case 2: $this->Button7->Font->Align = taRight; break;
                                case 3: $this->Button7->Font->Align = taCenter; break;
                                case 4: $this->Button7->Font->Align = taJustify; break;
                        }
                        $this->Button7->Font->Size = "{$fontSize}px";
                        $this->Button7->Font->Weight = ($fontWeight == 0) ? "" : "bold";
                        $this->Button7->Font->Color = "#".sprintf("%X%X%X", $fontColorR, $fontColorG, $fontColorB);
                }

                function Button9Click($sender, $params)
                {                
                        $this->Label2->Caption = "Clicked button: ".$sender->Name;
                }

                function Button8Click($sender, $params)
                {
                        echo "This should not be called when a button is disabled.";
                }


                function Button5JSClick($sender, $params)
                {                
                ?>
                        //Add your javascript code here
                        window.alert("So it can be used to handle JS events, etc.");
                <?php
                }

                function Button4JSClick($sender, $params)
                {
                ?>
                        //Add your javascript code here
                        window.alert("Get a free trial from http://www.codegear.com");
                <?php
                }

        
                
                function Button2Click($sender, $params)
                {
                        $r=dechex(rand(0,255));
                        $g=dechex(rand(0,255));
                        $b=dechex(rand(0,255));
                        $this->Button2->Color="#$r$g$b";
                        $this->Button2->Caption="Color: ".$this->Button2->Color;
                }

                function Button1Click($sender, $params)
                {
                        $this->Button1->Caption="Hello, World!";
                }

        }

        global $application;

        global $ButtonSample;

        //Creates the form
        $ButtonSample=new ButtonSample($application);

        //Read from resource file
        $ButtonSample->loadResource(__FILE__);

        //Shows the form
        $ButtonSample->show();

?>
