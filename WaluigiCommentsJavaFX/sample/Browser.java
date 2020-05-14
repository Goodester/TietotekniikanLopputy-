package sample;

import javafx.geometry.HPos;
import javafx.geometry.VPos;
import javafx.scene.layout.Region;
import javafx.scene.web.WebEngine;
import javafx.scene.web.WebView;

public class Browser extends Region {
    private static Browser ourInstance = new Browser();

    private final WebView webView = new WebView();
    private final WebEngine webEngine = webView.getEngine();
    private Taskbar taskbar = new Taskbar(webEngine);


    static Browser getInstance() {
        return ourInstance;
    }

    private Browser() {
        getChildren().add(webView);
        getChildren().add(taskbar);
    }

    public void loadPage(String url) {
        webEngine.load(url);
    }

    @Override
    protected void layoutChildren() {
        double currWidth = getWidth();
        double currHeight = getHeight();

        layoutInArea(webView,0, taskbar.getHeight(), currWidth, currHeight - taskbar.getHeight(),
                0, HPos.CENTER, VPos.CENTER);
        layoutInArea(taskbar,0,0, currWidth, taskbar.getHeight(),0, HPos.CENTER, VPos.CENTER);
    }
}
