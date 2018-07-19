
import java.util.ArrayList;

/*
 * @author maria
 */
public class Container {

    private int maxWeight = 0;
    private ArrayList<Suitcase> suitcases = new ArrayList<Suitcase>();

    public Container(int weight) {
        //set max weight for container
        maxWeight = weight;
    }

    public void addSuitcase(Suitcase suitcase) {

        //get total weight if this suitcase would be added
        if (suitcase.totalWeight() + containerWeight() <= maxWeight) {
            suitcases.add(suitcase);
        }
    }

    public int containerWeight() {
        //returns the total weight of suitcases in container
        int totalWeightOfSuitcases = 0;
        for (Suitcase row : suitcases) {
            totalWeightOfSuitcases += row.totalWeight();
        }
        return totalWeightOfSuitcases;
    }
    
    public void printThings() {
        for (Suitcase suitcase : suitcases) {
            suitcase.printThings();
        }       
    }

    public String toString() {
        int size = suitcases.size();
        String returnString = "";

        if (size == 0) {
            returnString = "empty";
        } else if (size == 1) {
            returnString = size + " suitcase";
        } else {
            returnString = size + " suitcases";
        }

        returnString += " (" + containerWeight() + " kg)";
        return returnString;
    }
}
