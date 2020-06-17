/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package fxml;

import Entite.Evennement;
import service.EvennementService;
import static fxml.ModifierEController.De;
import static fxml.ModifierEController.Em;
import static fxml.ModifierEController.Im;
import static fxml.ModifierEController.TI;
import static fxml.ModifierEController.ca;
import static fxml.ModifierEController.dad;
import static fxml.ModifierEController.daf;
import static fxml.ModifierEController.modifev;
import static fxml.ModifierEController.nbrp;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.JDBCType;
import static java.sql.JDBCType.NULL;
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
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.Pane;
import javafx.stage.Stage;
import utils.DataSource;

/**
 * FXML Controller class
 *
 * @author Houssem
 */
public class AfficherEController implements Initializable {

    @FXML
    private Button a;
    @FXML
    private TableView<Evennement> TT;
   @FXML
    private TableColumn<Evennement,String> imageE;

    @FXML
    private TableColumn<Evennement,String> Titre;

    @FXML
    private TableColumn<Evennement,String> emp;

    @FXML
    private TableColumn<Evennement,LocalDate> dateD;

    @FXML
    private TableColumn<Evennement,LocalDate> DATEF;

    @FXML
    private TableColumn<Evennement,Integer> NBRP;

    @FXML
    private TableColumn<Evennement,String> DESC;

    @FXML
    private TableColumn<Evennement,String> CATEG;
@FXML
    private AnchorPane bp;
 @FXML
    private Button ajterbtn;
  @FXML
    private TableColumn<Evennement, Integer> showa;
   @FXML
    private TextField recherchee;
   public static String chaine;
    @FXML
    private ImageView imgeev;
    Connection c;
    int A = 0;
    @FXML
    private Button versemplacement;
  public AfficherEController (){
        c = (Connection) DataSource.getInstance().getConnection();
    }
    
   
  /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
   EvennementService  es = new EvennementService();
        System.out.println("fxml.AfficherEController.initialize()");
        ArrayList<Evennement> arrayList = null;
        try {
            arrayList = (ArrayList<Evennement>) es.getAllP();
        } catch (SQLException ex) {
            Logger.getLogger(AfficherEController.class.getName()).log(Level.SEVERE, null, ex);
        }
        ObservableList obs = FXCollections.observableArrayList(arrayList);
        TT.setItems(obs);

        imageE.setCellValueFactory(new PropertyValueFactory<Evennement,String>("Image_Event"));
        Titre.setCellValueFactory(new PropertyValueFactory<Evennement,String>("Titre_Event"));
        CATEG.setCellValueFactory(new PropertyValueFactory<Evennement,String>("categorie_Event"));
         emp.setCellValueFactory(new PropertyValueFactory<Evennement,String>("EMPLACEMENT"));
          DESC.setCellValueFactory(new PropertyValueFactory<Evennement,String>("Descr_Event"));
          NBRP.setCellValueFactory(new PropertyValueFactory<Evennement,Integer>("nbr_place_E"));
       dateD.setCellValueFactory(new PropertyValueFactory<Evennement,LocalDate>("DATED_EVENT"));   
       DATEF.setCellValueFactory(new PropertyValueFactory<Evennement,LocalDate>("DATEF_EVENT"));
       showa.setCellValueFactory(new PropertyValueFactory<Evennement,Integer>("nbr_r"));
     

       
      
      
    }    
  

    @FXML
    private void affiche(ActionEvent event) throws SQLException, IOException {
        
       Stage stage = (Stage) bp.getScene().getWindow();
                System.err.println("bbb2");
           // Parent root=FXMLLoader.load(getClass().getClassLoader().getResource("fxml/ModifierE.fxml"));
            AnchorPane newLoadedPane = FXMLLoader.load(getClass().getResource("/fxml/ModifierE.fxml"));
				bp.getChildren().clear();
				bp.getChildren().add(newLoadedPane);
                                
    //  TT.setStyle("-fx-background-color : #53639F");
            //System.err.println(info);
          
      //      Scene scene = new Scene(root);
       //     stage.setScene(scene);
        //    stage.show();
        
        
        
    }
    
    
     @FXML
    void versaj(ActionEvent event) throws IOException {

          Stage stage = (Stage) bp.getScene().getWindow();
                System.err.println("bbb2");
            //Parent root=FXMLLoader.load(getClass().getClassLoader().getResource("fxml/AjouterEvnt.fxml"));
      AnchorPane newLoadedPane = FXMLLoader.load(getClass().getResource("/fxml/AjouterEvnt.fxml"));
				bp.getChildren().clear();
				bp.getChildren().add(newLoadedPane);
            //System.err.println(info);
          
         //   Scene scene = new Scene(root);
          //  stage.setScene(scene);
           // stage.show();
        
    }
    
    
     @FXML
    private void recherche_function(javafx.scene.input.KeyEvent event) {

        EvennementService fs = new EvennementService();
        ArrayList<Evennement> formations = new ArrayList<>();
        try {
            formations = (ArrayList<Evennement>) fs.rechercheEvennement(
                    recherchee.getText());
        } catch (SQLException ex) {
            Logger.getLogger(AfficherEController.class.getName()).log(Level.SEVERE, null, ex);
        }
        ObservableList<Evennement> obsl = FXCollections.observableArrayList(formations);
        TT.setItems(obsl);
        imageE.setCellValueFactory(new PropertyValueFactory<Evennement,String>("Image_Event"));
        Titre.setCellValueFactory(new PropertyValueFactory<Evennement,String>("Titre_Event"));
        CATEG.setCellValueFactory(new PropertyValueFactory<Evennement,String>("categorie_Event"));
        emp.setCellValueFactory(new PropertyValueFactory<Evennement,String>("EMPLACEMENT"));
        DESC.setCellValueFactory(new PropertyValueFactory<Evennement,String>("Descr_Event"));
        NBRP.setCellValueFactory(new PropertyValueFactory<Evennement,Integer>("nbr_place_E"));
        dateD.setCellValueFactory(new PropertyValueFactory<Evennement,LocalDate>("DATED_EVENT"));
        DATEF.setCellValueFactory(new PropertyValueFactory<Evennement,LocalDate>("DATEF_EVENT"));
        
        // prixtotale.setCellValueFactory(new PropertyValueFactory<>("5"));

    }

    @FXML
    private void getImage(MouseEvent event) throws FileNotFoundException, SQLException {
        Evennement song = TT.getSelectionModel().getSelectedItem();
       System.out.println( song.getImage_Event());
       int id=song.getId_Event();
       
        System.out.println(id);
       String req="select Image_Event from evenement where Id_Event ="+id;
       Statement ste= c.createStatement();
       ResultSet rs= ste.executeQuery(req);
       if(rs.next()){
           String title = rs.getString("Image_Event");
           System.out.println(title);
            Image image = new Image("file:C:/wamp64/www/" + title);
            imgeev.setImage(image);
       }
       this.A=id;
     
    }

    @FXML
    private void vers_emplacement(ActionEvent event) throws IOException {
        Evennement song = TT.getSelectionModel().getSelectedItem();
        System.out.println(song);
 modifev = song;
 EvennementService e = new EvennementService();
 if (song != null){
  
 ////////////
    
        System.out.println(song.getEMPLACEMENT());
        chaine=song.getEMPLACEMENT();
         Stage stage = (Stage) bp.getScene().getWindow();
                System.err.println("bbb2");
            //Parent root=FXMLLoader.load(getClass().getClassLoader().getResource("fxml/AjouterEvnt.fxml"));
      AnchorPane newLoadedPane = FXMLLoader.load(getClass().getResource("/fxml/emplacementmap.fxml"));
				bp.getChildren().clear();
				bp.getChildren().add(newLoadedPane);
        
    }}
    
}
