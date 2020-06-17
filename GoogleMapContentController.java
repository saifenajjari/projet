/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package fxml;

import java.net.URL;
import java.util.ResourceBundle;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import com.lynden.gmapsfx.GoogleMapView;
import com.lynden.gmapsfx.MapComponentInitializedListener;
import com.lynden.gmapsfx.javascript.object.GoogleMap;
import com.lynden.gmapsfx.javascript.object.LatLong;
import com.lynden.gmapsfx.javascript.object.MapOptions;
import com.lynden.gmapsfx.javascript.object.MapTypeIdEnum;
 import com.lynden.gmapsfx.javascript.object.Marker;
import com.lynden.gmapsfx.javascript.object.MarkerOptions;
import javafx.application.Platform;
import javafx.scene.layout.AnchorPane;

/**
 * FXML Controller class
 *
 * @author Legion
 */
public class GoogleMapContentController  implements Initializable, MapComponentInitializedListener {
 
  
        @FXML
    private AnchorPane AnchorPane;
    private final GoogleMapView mapView = new GoogleMapView("en-US", "AIzaSyB70HHhCezmeNImOymsvIeKzrvAEFouMIs");    
    private String adresse; 
    private int id_user; 

    public int getId_user() {
        return id_user;
    }

    public void setId_user(int id_user) {
        this.id_user = id_user;
    }

    public int getId_pc() {
        return id_pc;
    }

    public void setId_pc(int id_pc) {
        this.id_pc = id_pc;
    }
   private int id_pc;
    public String getAdresse() {
        return adresse;
    }

    public void setAdresse(String adresse) {
        this.adresse = adresse;
    }
     private int fonc; 

    public int getFonc() {
        return fonc;
    }

    public void setFonc(int fonc) {
        this.fonc = fonc;
    }
    private GoogleMap map; 
     private int id_cat; 

    public int getId_cat() {
        return id_cat;
    }

    public void setId_cat(int id_cat) {
        this.id_cat = id_cat;
    }
    /**
     * Initializes the controller class.
     */ 

 
 @Override
public void mapInitialized()  
{ 
           
              //Set the initial properties of the map.
    MapOptions mapOptions = new MapOptions();

     mapOptions.center(new LatLong(36, 10))
            .mapType(MapTypeIdEnum.ROADMAP)
            .overviewMapControl(false)
            .panControl(false)
            .rotateControl(false)
            .scaleControl(false)
            .streetViewControl(false)
            .zoomControl(false)
            .zoom(7);

    map = mapView.createMap(mapOptions);
 

 
 String[] arr = ss.split(","); 
    System.out.println(arr[0]);
    System.out.println(arr[1]);
Float  lat =Float.parseFloat(arr[0]); 
Float longi =Float.parseFloat(arr[1]); 

//Add a marker to the map
     MarkerOptions markerOptions = new MarkerOptions();
     markerOptions.position( new LatLong(lat,longi) )
                .visible(Boolean.TRUE)
                .title("My Marker");
     Marker marker = new Marker( markerOptions ); 
    map.addMarker(marker);




}
    
    @Override
    public void initialize(URL url, ResourceBundle rb)  
    { 

     //Create the JavaFX component and set this as a listener so we know when 
    //the map has been initialized, at which point we can then begin manipulating it.
 
  Platform.runLater(() -> {  
   
      mapView.addMapInializedListener(this); 
     AnchorPane.getChildren().add(mapView);
                      System.out.println(this.getAdresse()+"yes");
  });  
    }    

   
    
}
