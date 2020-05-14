package sample.buttons;

import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.web.WebEngine;
import javafx.scene.web.WebHistory;

public class GoBackwardsInHistoryButton extends HistoryChangerButton {
    private Image image = new Image(getClass().getResourceAsStream("images/arrowPointingLeft.png"),
                      30,  30, true, true);
    private Image imageActive = new Image(getClass().getResourceAsStream("images/arrowPointingLeftActive.png"),
                            30,  30, true, true);
    private ImageView imageView = new ImageView(image);

    private WebEngine webEngine;

    public GoBackwardsInHistoryButton(WebEngine webEngine) {
        super();

        this.webEngine = webEngine;
        setGraphic(imageView);

        setOnAction(event -> {
            imageView.setImage(imageActive);
            changeHistory();

            new java.util.Timer().schedule(
                    new java.util.TimerTask() {
                        @Override
                        public void run() {
                            imageView.setImage(image);
                        }
                    }, 150
            );
        });
    }

    protected void changeHistory() {
        WebHistory history = webEngine.getHistory();

        if (history.getCurrentIndex() > 0) {
            history.go(-1);
        }
    }
}
