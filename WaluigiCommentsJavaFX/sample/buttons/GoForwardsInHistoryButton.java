package sample.buttons;

import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.web.WebEngine;
import javafx.scene.web.WebHistory;

public class GoForwardsInHistoryButton extends HistoryChangerButton {
    private Image image = new Image(getClass().getResourceAsStream("images/arrowPointingRight.png"),
                              30,  30, true, true);
    private Image imageActive = new Image(getClass().getResourceAsStream("images/arrowPointingRightActive.png"),
                    30,  30, true, true);
    private ImageView imageView = new ImageView(image);

    private WebEngine webEngine;

    public GoForwardsInHistoryButton(WebEngine webEngine) {
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

    @Override
    protected void changeHistory() {
        WebHistory history = webEngine.getHistory();

        if (history.getCurrentIndex() < (history.getEntries().size() - 1)) {
            history.go(1);
        }
    }
}
