/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package fxml;

import Entite.Evennement;
import Entite.Reservation;
import Entite.User;

import static fxml.ModifierEController.modifev;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.Date;
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
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.KeyEvent;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;
import service.EvennementService;
import service.ReservationService;
import tray.animations.AnimationType;
import tray.notification.NotificationType;
import tray.notification.TrayNotification;
import utils.DataSource;

/**
 * FXML Controller class
 *
 * @author saife
 */
public class AfficherfrontController implements Initializable {

    @FXML
    private TableView<Evennement> TT;
    @FXML
    private TableColumn<Evennement, String> imageE;

    @FXML
    private TableColumn<Evennement, String> Titre;

    @FXML
    private TableColumn<Evennement, String> emp;

    @FXML
    private TableColumn<Evennement, LocalDate> dateD;

    @FXML
    private TableColumn<Evennement, LocalDate> DATEF;

    @FXML
    private TableColumn<Evennement, Integer> NBRP;

    @FXML
    private TableColumn<Evennement, String> DESC;

    @FXML
    private TableColumn<Evennement, String> CATEG;
    @FXML
    private AnchorPane bp;
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
    private Button reserrverbtn;

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        EvennementService es = new EvennementService();
        System.out.println("fxml.AfficherEController.initialize()");
        ArrayList<Evennement> arrayList = null;
        try {
            arrayList = (ArrayList<Evennement>) es.getAllP();
        } catch (SQLException ex) {
            Logger.getLogger(AfficherEController.class.getName()).log(Level.SEVERE, null, ex);
        }
        ObservableList obs = FXCollections.observableArrayList(arrayList);
        TT.setItems(obs);

        imageE.setCellValueFactory(new PropertyValueFactory<Evennement, String>("Image_Event"));
        Titre.setCellValueFactory(new PropertyValueFactory<Evennement, String>("Titre_Event"));
        CATEG.setCellValueFactory(new PropertyValueFactory<Evennement, String>("categorie_Event"));
        emp.setCellValueFactory(new PropertyValueFactory<Evennement, String>("EMPLACEMENT"));
        DESC.setCellValueFactory(new PropertyValueFactory<Evennement, String>("Descr_Event"));
        NBRP.setCellValueFactory(new PropertyValueFactory<Evennement, Integer>("nbr_place_E"));
        dateD.setCellValueFactory(new PropertyValueFactory<Evennement, LocalDate>("DATED_EVENT"));
        DATEF.setCellValueFactory(new PropertyValueFactory<Evennement, LocalDate>("DATEF_EVENT"));
        showa.setCellValueFactory(new PropertyValueFactory<Evennement, Integer>("nbr_r"));

    }

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
        imageE.setCellValueFactory(new PropertyValueFactory<Evennement, String>("Image_Event"));
        Titre.setCellValueFactory(new PropertyValueFactory<Evennement, String>("Titre_Event"));
        CATEG.setCellValueFactory(new PropertyValueFactory<Evennement, String>("categorie_Event"));
        emp.setCellValueFactory(new PropertyValueFactory<Evennement, String>("EMPLACEMENT"));
        DESC.setCellValueFactory(new PropertyValueFactory<Evennement, String>("Descr_Event"));
        NBRP.setCellValueFactory(new PropertyValueFactory<Evennement, Integer>("nbr_place_E"));
        dateD.setCellValueFactory(new PropertyValueFactory<Evennement, LocalDate>("DATED_EVENT"));
        DATEF.setCellValueFactory(new PropertyValueFactory<Evennement, LocalDate>("DATEF_EVENT"));

        // prixtotale.setCellValueFactory(new PropertyValueFactory<>("5"));
    }

    private void getImage(MouseEvent event) throws FileNotFoundException, SQLException {
        Evennement song = TT.getSelectionModel().getSelectedItem();
        System.out.println(song.getImage_Event());
        int id = song.getId_Event();

        System.out.println(id);
        String req = "select Image_Event from evenement where Id_Event =" + id;
        Statement ste = c.createStatement();
        ResultSet rs = ste.executeQuery(req);
        if (rs.next()) {
            String title = rs.getString("Image_Event");
            System.out.println(title);
            Image image = new Image("file:C:/wamp64/www/" + title);
            imgeev.setImage(image);
        }
        this.A = id;

    }

    private void vers_emplacement(ActionEvent event) throws IOException {
        Evennement song = TT.getSelectionModel().getSelectedItem();
        System.out.println(song);
        modifev = song;
        EvennementService e = new EvennementService();
        if (song != null) {

            ////////////
            System.out.println(song.getEMPLACEMENT());
            chaine = song.getEMPLACEMENT();
            Stage stage = (Stage) bp.getScene().getWindow();
            System.err.println("bbb2");
            //Parent root=FXMLLoader.load(getClass().getClassLoader().getResource("fxml/AjouterEvnt.fxml"));
            AnchorPane newLoadedPane = FXMLLoader.load(getClass().getResource("/fxml/emplacementmap.fxml"));
            bp.getChildren().clear();
            bp.getChildren().add(newLoadedPane);

        }
    }

    @FXML
    private void reserver(ActionEvent event) throws SQLException {
        /*    }

        if (TT.getSelectionModel().getSelectedItem() == null) {

            Alert alert1 = new Alert(Alert.AlertType.WARNING);
            alert1.setTitle("Erreur");
            alert1.setContentText("Vous devez selectionner le plat à reserver");
            alert1.setHeaderText(null);
            alert1.show();
        } else {
            int Id_Event = TT.getSelectionModel().getSelectedItem().getId_Event();
            ReservationService rs = new ReservationService();
            Evennement pl = TT.getSelectionModel().getSelectedItem();
            String a = TT.getSelectionModel().getSelectedItem().getTitre_Event();
            Reservation t = new Reservation(a, Id_Event);
            rs.ajouterReservation(t);
            

            //int id_user = LoginController.userConnected.getId();
         */
        String tit = "Réservation réussite";
            String message = "evenement reservé avec succées, Merci pour votre participation  ";
            NotificationType notification = NotificationType.SUCCESS;
    
            TrayNotification tray = new TrayNotification(tit, message, notification);          
            tray.setAnimationType(AnimationType.POPUP);
            tray.showAndDismiss(javafx.util.Duration.seconds(10));

        try {
            javafx.scene.Parent tableview = FXMLLoader.load(getClass().getResource("/fxml/Paiementevent.fxml"));
            Scene sceneview = new Scene(tableview);
            Stage window = (Stage) ((Node) event.getSource()).getScene().getWindow();
            window.setScene(sceneview);
            window.show();
        } catch (IOException ex) {
            System.out.println(ex.getMessage());

        }

    }

    public void ajouterReservationn(Reservation R) throws SQLException {

        String query;
        query = "INSERT INTO `reservation`( `Id_Event`, `Id_User`, `Etat_Res`, `Titre_Event`, `DATED_EVENT`, `DATEF_EVENT`, `ImageEvent`) VALUES (?,?,?,?,?,?,?,?) ";
        PreparedStatement pst = DataSource.getInstance().getConnection().prepareStatement(query);

        pst.setInt(1, R.getId_Event());

        pst.setInt(2, R.getId_User());

        pst.setString(3, R.getEtat());

        pst.setString(4, R.getTitre_Event());
        //pst.setDate(5,to_date('29-Oct-09', 'DD-Mon-YY'));
        //pst.set(6,R.getDATED_EVENT());
        //  pst.setString(6,R.);

        pst.executeUpdate();
    }

    @FXML
    private void select(MouseEvent event) {
        Evennement selected = TT.getSelectionModel().getSelectedItem();
        if (!TT.getSelectionModel().getSelectedItems().isEmpty()) {

            Titre.setText(selected.getTitre_Event());

        } else {
            Alert alert = new Alert(Alert.AlertType.ERROR);
            alert.setTitle("Information Dialog");
            alert.setHeaderText(null);
            alert.setContentText("selectionnez un événement à evaluer !!");
            alert.showAndWait();
        }
    }

}
