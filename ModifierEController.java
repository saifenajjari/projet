/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package fxml;

import Entite.Evennement;
import service.EvennementService;
import facebook4j.Facebook;
import facebook4j.FacebookException;
import facebook4j.FacebookFactory;
import facebook4j.auth.AccessToken;
import facebook4j.conf.ConfigurationBuilder;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.time.LocalDate;
import java.util.ArrayList;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.DatePicker;
import javafx.scene.control.Spinner;
import javafx.scene.control.SpinnerValueFactory;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;
import javax.swing.JOptionPane;
import utils.DataSource;

/**
 * FXML Controller class
 *
 * @author Houssem
 */
public class ModifierEController implements Initializable {
 //Evennement E1 = new Evennement( DESCmm.getText(),imageEmm.getText(),Titremm.getText(),datd.getValue(),datf.getValue(),empmm.getText(),12,categmm.getText(),(int) nbr_place_E1.getValueFactory().getValue());     
    public static String De ;
    public static String Im ;
    public static String TI ;
    public static LocalDate dad ;
    public static LocalDate daf ;
    public static String Em ;
    public static String ca;
    public static int nbrp;
    public static Evennement modifev;
    
     Connection c = DataSource.getInstance().getConnection();
    Statement ste;
  
    @FXML
    private AnchorPane bp;
    @FXML
    private TableView<Evennement> TTm;
    @FXML
    private TableColumn<Evennement,String> imageEm;
    @FXML
    private TableColumn<Evennement,String> Titrem;
    @FXML
    private TableColumn<Evennement,String> empm;
    @FXML
    private TableColumn<Evennement,LocalDate> dateDm;
    @FXML
    private TableColumn<Evennement,LocalDate> DATEFm;
    @FXML
    private TableColumn<Evennement,Integer> NBRPm;
    @FXML
    private TableColumn<Evennement,String> DESCm;
    @FXML
    private TableColumn<Evennement,String> CATEGm;
@FXML
    private Button supprimE;
 @FXML
    private Button up;
    private Spinner  nbr_place_E1;
    private Facebook facebook;
    @FXML
    private Button sha;
    @FXML
    private Button boutonretour;
/**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        System.out.println("fxml.ModifierEController");
       
        
 EvennementService  es = new EvennementService();
        System.out.println("fxml.AfficherEController.initialize()");
        
        ////////////////
        
     
//if ("admin".equals(res.getString(1)) ) 
        
        
        ///////////////
        ArrayList<Evennement> arrayList = null;
        try {
            arrayList = (ArrayList<Evennement>) es.getAllP1();
        } catch (SQLException ex) {
            Logger.getLogger(ModifierEController.class.getName()).log(Level.SEVERE, null, ex);
        }
        ObservableList obs = FXCollections.observableArrayList(arrayList);
        TTm.setItems(obs);

        imageEm.setCellValueFactory(new PropertyValueFactory<Evennement,String>("Image_Event"));
        Titrem.setCellValueFactory(new PropertyValueFactory<Evennement,String>("Titre_Event"));
        CATEGm.setCellValueFactory(new PropertyValueFactory<Evennement,String>("categorie_Event"));
         empm.setCellValueFactory(new PropertyValueFactory<Evennement,String>("EMPLACEMENT"));
          DESCm.setCellValueFactory(new PropertyValueFactory<Evennement,String>("Descr_Event"));
          NBRPm.setCellValueFactory(new PropertyValueFactory<Evennement,Integer>("nbr_place_E"));
       dateDm.setCellValueFactory(new PropertyValueFactory<Evennement,LocalDate>("DATED_EVENT"));   
       DATEFm.setCellValueFactory(new PropertyValueFactory<Evennement,LocalDate>("DATEF_EVENT"));   
      

// TODO
    }    
    
      @FXML
    void supprimerE(ActionEvent event) throws SQLException {
 Evennement song = TTm.getSelectionModel().getSelectedItem();
 System.out.println(song);
 EvennementService e = new EvennementService();
 TTm.getItems().removeAll(TTm.getSelectionModel().getSelectedItem());
 if (song != null){
   JOptionPane.showMessageDialog(null,"supprimee");   
 e.supprimerEvennement(song);
 }
    
   

    


        
    }
     @FXML
    void up(ActionEvent event) throws IOException {
        
Evennement song = TTm.getSelectionModel().getSelectedItem();
 System.out.println(song);
 modifev = song;
 EvennementService e = new EvennementService();
 if (song != null){
  
 ////////////
    De = song.getDescr_Event();
     Im=song.getImage_Event() ;
     TI =song.getTitre_Event();
     dad = song.getDATED_EVENT();
     daf=song.getDATEF_EVENT() ;
    Em =song.getEMPLACEMENT();
     ca=song.getCategorie_Event();
     nbrp=song.getNbr_place_E();
 /////modifier jdida
   Stage stage = (Stage) bp.getScene().getWindow();
                System.err.println("bbb2");
           // Parent root=FXMLLoader.load(getClass().getClassLoader().getResource("fxml/ModifierE.fxml"));
       AnchorPane newLoadedPane = FXMLLoader.load(getClass().getResource("/fxml/Modifierev.fxml"));
				bp.getChildren().clear();
				bp.getChildren().add(newLoadedPane);
 
 }
    }
      
    private void sharefa(ActionEvent event) {
        
        
        
        System.out.println("hetha1");
        facebook = new FacebookFactory().getInstance();
        
        facebook.setOAuthAppId("Saif Najjari", "123456789omisouad");//ysta3mlouh fazat connexion fb 
        
        String accessTokenString = "EAAJNtvAALykBANnWn6PSQJwbB73M3K7OB8a6F1efssMMNS7XdnciwmuPOSDH9X8NDWGRgZB6JWQmnRZBOE0Ker5VNLqZB4XX6QC8ZB5YsjvWRvx73RGmSi9qZAGYQ4rM1yZAJKe8ZAfXtp8idmUQGzEkayNJS3bORP1WSLdLiZB4uvYAfgHVREn8VQkILBxshoXSZBk36fbVCYgk0nqTQJlqIrWxeeGobIJmZC3MKZCbJuwDPtwZC3pcBgc3qYxaaKseHtUZD";
        AccessToken accessToken = new AccessToken(accessTokenString);
        //set access token
        facebook.setOAuthAccessToken(accessToken);
        //ResponseList<Account> accounts = facebook.getAccounts();
       // Account pageAccount = accounts.get(0);
        try{
       facebook.postStatusMessage("La plante ");
        }catch(FacebookException fe){
            Alert alert = new Alert(Alert.AlertType.ERROR);
        alert.setTitle("Deja partager.");
        alert.setHeaderText(null);
      //  alert.setContentText("La plant  "+p.getNamePlant()+ " a été deja partager.");
        alert.showAndWait();
    }}

    @FXML
    private void shar(ActionEvent event) throws FacebookException {
        
        System.out.println("hetha2");
        
        
               Evennement song = TTm.getSelectionModel().getSelectedItem();

           facebook = new FacebookFactory().getInstance();
        
        facebook.setOAuthAppId("", "");//ysta3mlouh fazat connexion fb 
        String accessTokenString = "EAAJNtvAALykBAPp6B2SDB5piztF26Qztx0vGyK46fXp0qhJee1VSd3gmJzSOEee1khAN5ytNiB2YRiKvfQz4lKSAIztGz4adeqU2fsVof7T0w1fR1JjQaqCN055edbH4R2NqwgJVBIKuiTelx3FIbNpZB0NnAZAkoMAhhV0Pp4ZBBmJEDGCvEKip9psXyMZD";
        AccessToken accessToken = new AccessToken(accessTokenString);
        //set access token
        facebook.setOAuthAccessToken(accessToken);
        //ResponseList<Account> accounts = facebook.getAccounts();
       // Account pageAccount = accounts.get(0);
       try{
       facebook.postStatusMessage("Le titre est le "+ song.getTitre_Event()+"date est");
            System.out.println("fxml.ModifierEController.shar()");}
            catch(FacebookException fe){
                System.out.println("sss"+ fe.getMessage());
            Alert alert = new Alert(Alert.AlertType.ERROR);
        alert.setTitle("Evenement deja partagé.");
        alert.setHeaderText(null);
        alert.setContentText("Error");
        alert.showAndWait();
       
         //   Alert alert = new Alert(Alert.AlertType.ERROR);
      //  alert.setTitle("Deja partager.");
  //      alert.setHeaderText(null);
      //  alert.setContentText("La plant  "+p.getNamePlant()+ " a été deja partager.");
     //   alert.showAndWait();
            }
    }

    @FXML
    private void retouev(ActionEvent event) {
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
