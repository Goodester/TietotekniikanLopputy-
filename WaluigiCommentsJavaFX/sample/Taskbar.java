package sample;

import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.Cursor;
import javafx.scene.Node;
import javafx.scene.control.Button;
import javafx.scene.layout.*;
import javafx.scene.paint.Color;
import javafx.scene.web.WebEngine;
import sample.buttons.GoBackwardsInHistoryButton;
import sample.buttons.GoForwardsInHistoryButton;
import sample.buttons.RefreshButton;


class Taskbar extends HBox {
    private WebEngine webEngine;
    private Background background;

    Taskbar(WebEngine webEngine) {
        this(
                webEngine,
                new Background(new BackgroundFill
                        (
                            Color.rgb(255, 255, 255),
                            CornerRadii.EMPTY,
                            Insets.EMPTY
                        )
                )
        );
    }

    Taskbar(WebEngine webEngine, Background background) {
        super();
        this.background = background;
        setBackground(this.background);

        this.webEngine = webEngine;

        // node initializations
        HBox leftSideCont = new HBox(10);
        Button goBackwardsButton = new GoBackwardsInHistoryButton(webEngine);
        goBackwardsButton.setBackground(this.background);
        goBackwardsButton.setMinSize(30, 30);
        goBackwardsButton.setMaxSize(30, 30);
        setCursorHovering(goBackwardsButton);
        Button goForwardsButton = new GoForwardsInHistoryButton(webEngine);
        goForwardsButton.setBackground(this.background);
        goForwardsButton.setMinSize(30, 30);
        goForwardsButton.setMaxSize(30, 30);
        setCursorHovering(goForwardsButton);

        Region centerCont = new Region();

        Button refreshButton = new RefreshButton(webEngine);
        refreshButton.setBackground(this.background);
        refreshButton.setMinSize(30, 30);
        refreshButton.setMaxSize(30, 30);
        setCursorHovering(refreshButton);

        leftSideCont.setAlignment(Pos.CENTER_LEFT);
        HBox.setHgrow(centerCont, Priority.ALWAYS);
        refreshButton.setAlignment(Pos.CENTER_RIGHT);

        // adding the children
        leftSideCont.getChildren().addAll(goBackwardsButton, goForwardsButton);
        getChildren().addAll(leftSideCont, centerCont, refreshButton);
    }


    private void setCursorHovering(Node node) {
        node.setOnMouseEntered(e -> getScene().setCursor(Cursor.HAND));
        node.setOnMouseExited(e -> getScene().setCursor(Cursor.DEFAULT));
    }
}
