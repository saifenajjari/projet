/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package fxml;

import service.ReservationService;
import com.jfoenix.controls.JFXButton;
import com.jfoenix.controls.JFXTextField;
import java.net.URL;
import java.sql.SQLException;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.layout.Pane;

/**
 * FXML Controller class
 *
 * @author LENOVO
 */
public class ModifierController implements Initializable {
         @FXML
    private JFXTextField nom;
              @FXML
    private JFXTextField idtitre;
                  @FXML
    private JFXTextField idmail;
                         @FXML
    private JFXTextField idnum;
         @FXML
  private JFXButton val;
           @FXML
    private Pane pane1;
              
  
    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    
         public void LOG2(String text)
    {
        nom.setText(text);
    }
    
         
         @FXML
    private void valider(ActionEvent event) throws SQLException{
         String titre=idtitre.getText();
         String login=nom.getText();
         String email =idmail.getText();
         int num= (Integer.valueOf(idnum.getText()));
             ReservationService RS = new  ReservationService();
             RS.modifierReser(titre, login,email,num);
             System.out.println("modification ok ");
}
}
