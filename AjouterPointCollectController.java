/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package fxml;

 import com.jfoenix.controls.JFXTextField;
import com.lynden.gmapsfx.GoogleMapView;
import com.lynden.gmapsfx.MapComponentInitializedListener;
import com.lynden.gmapsfx.javascript.event.UIEventType;
import com.lynden.gmapsfx.javascript.object.GoogleMap;
import com.lynden.gmapsfx.javascript.object.LatLong;
import com.lynden.gmapsfx.javascript.object.MapOptions;
import com.lynden.gmapsfx.javascript.object.MapTypeIdEnum;
import com.lynden.gmapsfx.javascript.object.Marker;
import com.lynden.gmapsfx.javascript.object.MarkerOptions;
import java.io.IOException;
import java.net.URL;
import java.sql.SQLException;
import java.util.List;
import java.util.Optional;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.application.Platform;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.control.Alert;
import javafx.scene.control.ButtonType;
import javafx.scene.control.TextField;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.GridPane;
import javafx.stage.Stage;
import netscape.javascript.JSObject;

/**
 * FXML Controller class
 *
 * @author Legion
 */
public class AjouterPointCollectController implements Initializable,MapComponentInitializedListener {

    
    @FXML
    private AnchorPane bp;
    @FXML
    private GridPane mapV;


    @FXML
    private TextField idLongitude;
    private final GoogleMapView mapView = new GoogleMapView("en-US", "AIzaSyB70HHhCezmeNImOymsvIeKzrvAEFouMIs");    
    private GoogleMap map; 
public static String longitude;
    /**
     * Initializes the controller class.
     */ 
    
         MarkerOptions markerOptions = new MarkerOptions();
    @FXML
    private TextField idAdresse;

         @Override
public void mapInitialized()  
{
    
    System.out.println("hnaaa2");
           
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
 
  



map.addUIEventHandler(map, UIEventType.click, ((jso) -> {
    System.out.println("Views.AjouterPointCollectController.mapInitialized()");   
              LatLong latLong = new LatLong( (JSObject) jso.getMember( "latLng" ) ); 
          System.out.println("Latitude: " + latLong.getLatitude());
   System.out.println("Longitude: " + latLong.getLongitude());
 ///
     markerOptions.position( new LatLong(latLong.getLatitude(),latLong.getLongitude()) )
                .visible(Boolean.TRUE) 
                .title("My Marker"); 
      Marker marker = new Marker( markerOptions ); 
      map.addMarker(marker); 
 String coordonne =String.valueOf(latLong.getLatitude())+","+String.valueOf(latLong.getLongitude());    
    System.out.println(coordonne);
 idLongitude.setText(coordonne);
} ));

}
     
    @FXML
 void valider(ActionEvent event) throws IOException {
longitude=idLongitude.getText();
 Stage stage = (Stage) bp.getScene().getWindow();
                System.err.println("bbb2");
            //Parent root=FXMLLoader.load(getClass().getClassLoader().getResource("fxml/AfficherE.fxml"));
       AnchorPane newLoadedPane = FXMLLoader.load(getClass().getResource("/fxml/AjouterEvnt.fxml"));
				bp.getChildren().clear();
				bp.getChildren().add(newLoadedPane);
         
        System.out.println("Cool !");
    }


        
    @Override
    public void initialize(URL url, ResourceBundle rb) { 
        // TODO 
        
  Platform.runLater(() -> {  
      mapView.addMapInializedListener(this); 
     mapV.getChildren().add(mapView);
   });  
    }
    
    }    
    

