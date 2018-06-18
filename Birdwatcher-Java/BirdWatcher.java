
import java.util.ArrayList;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 *
 * @author maria
 */
public class BirdWatcher {

    private ArrayList<Bird> birds;

    public BirdWatcher() {
        this.birds = new ArrayList<Bird>();
    }
    
    public void addBird(Bird newBird) {
        birds.add(newBird);
    }
    
    public Bird getBird(String name) {
        for (Bird bird : this.birds) {
            if (bird.getName().contains(name)) {
                return bird;
            }
        }
        return null;
    }
    public void printBirds() {
        for (Bird bird : this.birds) {
            System.out.println(bird.toString() + ": " + bird.getObservations() + " observations");
        }
    }
}
