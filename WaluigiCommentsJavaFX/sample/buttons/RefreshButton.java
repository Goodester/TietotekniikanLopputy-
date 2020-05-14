package sample.buttons;

import javafx.scene.control.Button;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.web.WebEngine;

public class RefreshButton extends Button {
    private Image image = new Image(getClass().getResourceAsStream("images/refresh.png"),
            30, 30, true, true);
    private Image imageActive = new Image(getClass().getResourceAsStream("images/refreshActive.png"),
            30, 30, true, true);
    private ImageView imageView = new ImageView(image);

    private WebEngine webEngine;

    public RefreshButton(WebEngine webEngine) {
        super();

        this.webEngine = webEngine;

        setGraphic(imageView);
        setOnAction(event -> {
            refresh();
            System.out.println();
            imageView.setImage(imageView.getImage().equals(image) ?
                               imageActive : image);
        });
    }

    private void refresh() {
        webEngine.reload();
    }
}
