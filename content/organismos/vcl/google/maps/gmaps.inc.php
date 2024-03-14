<?php
        //Includes
        require_once("vcl/vcl.inc.php");

        use_unit("controls.inc.php");

        //Class definition
        class GoogleMap extends Control
        {
            function __construct($aowner = null)
            {
                parent::__construct($aowner);
            }

            private $_mapskey="ABQIAAAAQlQ8ZvigZnDc1z7MTEuUQxTJO8fVsnY3pyCJC531oZiosu_8phSnTlxi08R1_58Gfdyd9NUJdyES5w";

            function getMapsKey() { return $this->_mapskey; }
            function setMapsKey($value) { $this->_mapskey=$value; }
            function defaultMapsKey() { return "ABQIAAAAQlQ8ZvigZnDc1z7MTEuUQxTJO8fVsnY3pyCJC531oZiosu_8phSnTlxi08R1_58Gfdyd9NUJdyES5w"; }

            private $_address="Scotts Valley, CA";

            function getAddress() { return $this->_address; }
            function setAddress($value) { $this->_address=$value; }
            function defaultAddress() { return "Scotts Valley, CA"; }



            function dumpHeaderCode()
            {
?>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $this->MapsKey; ?>"
      type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[
    function <?php echo $this->Name; ?>load()
    {
      if (GBrowserIsCompatible())
      {
        var map = new GMap2(document.getElementById("<?php echo $this->Name; ?>_div"));
        map.addControl(new GLargeMapControl());
        map.addControl(new GScaleControl());
        map.addControl(new GMapTypeControl());

        var geocoder = new GClientGeocoder();

        var address="<?php echo $this->Address; ?>";

        geocoder.getLatLng (address,

        function(point)
        {
                if (!point)
                {
                        alert(address + " not found");
                }
                else
                {
                        map.setCenter(point, 13);
                        var marker = new GMarker(point);
                        map.addOverlay(marker);
                        marker.openInfoWindowHtml(address);
                }
        }
        );
      }
   }
    //]]>
    </script>
<?php
            }

            function dumpContents()
            {
                echo "<div id=\"".$this->Name."_div\" style=\"width: ".$this->Width."px; height: ".$this->Height."px\"></div>";
?>
    <script type="text/javascript">
    <?php echo $this->Name; ?>load();
    </script>
<?php
            }
        }

?>
