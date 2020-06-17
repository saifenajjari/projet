/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package fxml;

import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.application.Platform;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.control.Button;
import javafx.scene.layout.Pane;
import javafx.stage.Stage;
import javafx.stage.Window;

/**
 * FXML Controller class
 *
 * @author aymen
 */
public class GoogleMapController implements Initializable {
  @FXML
    private Button idlogout;
    @FXML
    private Pane pane;



   private String adresse;  
   private int id_user; 
   private int id_pc; 
   private int fonc;  
   private int id_cat; 

    public int getId_cat() {
        return id_cat;
    }

    public void setId_cat(int id_cat) {
        this.id_cat = id_cat;
    }

    public int getFonc() {
        return fonc;
    }

    public void setFonc(int fonc) {
        this.fonc = fonc;
    }

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
   

    public String getAdresse() {
        return adresse;
    }

    public void setAdresse(String adresse) {
        this.adresse = adresse;
    }


 Node[] n=new Node[20];
   
 
   
    @FXML
    void logout(ActionEvent event) {
                  Window window = idlogout.getScene().getWindow(); 

     if (window instanceof Stage){ 
      ((Stage) window).close(); 
     } 


    }
  
  /**
     * Initializes the controller class.
     * @param url
     * @param rb
     */
  @Override
  @SuppressWarnings("empty-statement")
     public void initialize(URL url, ResourceBundle rb) {
         pane.getChildren().clear();
             Platform.runLater(() -> {
                 try {
                     FXMLLoader fxmlLoader = new FXMLLoader(GoogleMapController.this.getClass().getResource("/Views/GoogleMapContent.fxml"));
                     n[6]=(Node)fxmlLoader.load();
                     GoogleMapContentController controller = fxmlLoader.<GoogleMapContentController>getController();
                     controller.setAdresse(adresse);
                     controller.setId_user(id_user);
                     controller.setFonc(fonc);
                     controller.setId_cat(id_cat);
                     pane.getChildren().add(n[6]);
                     //do stuff
                 }catch (IOException ex) {
                 }                ;
         });     } 
     
      @FXML
    void AcceuilAdmin(ActionEvent event) {
           pane.getChildren().clear();
        
                            try {
          
           FXMLLoader loader =new FXMLLoader(getClass().getResource("/Views/AcceuilAdmin.fxml"));
           n[11]=loader.load();
        
           pane.getChildren().add(n[11]);
       } catch (IOException ex) {
       }
        
        
        System.out.println("Views.BackendController.AjouterPoint()");

    }

 

    @FXML
    void AjouterPointCollect(ActionEvent event) {
         pane.getChildren().clear();
        
                            try {
          
           FXMLLoader loader =new FXMLLoader(getClass().getResource("/Views/AjouterPointCollect.fxml"));
           n[10]=loader.load();
     

           pane.getChildren().add(n[10]);
       } catch (IOException ex) {
       }
        
        
        System.out.println("Views.BackendController.AjouterPoint()");

    }

  

   


   

  

   

   

    
}











