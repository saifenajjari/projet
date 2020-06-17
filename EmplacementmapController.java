/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package fxml;

import com.lynden.gmapsfx.GoogleMapView;
import com.lynden.gmapsfx.MapComponentInitializedListener;
import com.lynden.gmapsfx.javascript.object.GoogleMap;
import com.lynden.gmapsfx.javascript.object.LatLong;
import com.lynden.gmapsfx.javascript.object.MapOptions;
import com.lynden.gmapsfx.javascript.object.MapTypeIdEnum;
import com.lynden.gmapsfx.javascript.object.Marker;
import com.lynden.gmapsfx.javascript.object.MarkerOptions;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.application.Platform;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.layout.GridPane;
import javafx.stage.Stage;
import static jdk.nashorn.internal.objects.NativeArray.map;

/**
 * FXML Controller class
 *
 * @author Houssem
 */
public class EmplacementmapController implements Initializable,MapComponentInitializedListener {

    @FXML
    private GridPane mapV2;
    private GoogleMap map; 
    private GoogleMapView mapView = new GoogleMapView("en-US", "AIzaSyB70HHhCezmeNImOymsvIeKzrvAEFouMIs"); 
// private GoogleMapView mapView = new GoogleMapView("en-US", "AIzaSyB70HHhCezmeNImOymsvIeKzrvAEFouMIs");    
 //   private GoogleMap map; 
public static String longitude;
    /**
     * Initializes the controller class.
     */ 
    
         MarkerOptions markerOptions = new MarkerOptions();
   
    @Override
    public void initialize(URL url, ResourceBundle rb) {
                System.out.println("iniiiiiiiiiiiiiiiiiiiiit");
  Platform.runLater(() -> {  
      mapView.addMapInializedListener(this); 
     mapV2.getChildren().add(mapView);
   });  
       
  
  
    }    

    @Override
    public void mapInitialized() {

        
        System.out.println("hnaa");
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
 

 
 String[] arr = AfficherEController.chaine.split(","); 
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


        // TODO    }
    
}
    @FXML
    private void Retour(ActionEvent event) {
        try {
        javafx.scene.Parent tableview = FXMLLoader.load(getClass().getResource("/fxml/afficherE.fxml"));
        Scene sceneview = new Scene(tableview);
        Stage window = (Stage)((Node)event.getSource()).getScene().getWindow();
        window.setScene(sceneview);
        window.show();
        } catch (IOException ex) {
            System.out.println(ex.getMessage());
        }
    }
}
