package sample;

import javafx.application.Application;
import javafx.scene.Scene;
import javafx.scene.paint.Color;
import javafx.stage.Stage;

public class Main extends Application {
    @Override
    public void start(Stage stage) {
        Scene scene;

        stage.setTitle("Waluigi Comments");
        stage.setMinWidth(500);
        stage.setMaximized(true);

        Browser browser = Browser.getInstance();
        browser.loadPage("https://waluigi-comments.website");

        scene = new Scene(browser, 1000, 750, Color.web("#666970"));
        stage.setScene(scene);
        stage.show();
    }

    public static void main(String[] args){
        launch(args);
    }
}
