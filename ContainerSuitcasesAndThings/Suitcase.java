
import java.util.ArrayList;

/**
 *
 * @author maria
 */
public class Suitcase {

    private int maxWeight = 0;
    private ArrayList<Thing> things = new ArrayList<Thing>();

    public Suitcase(int weigth) {
        //set maxweight
        this.maxWeight = weigth;
    }

    public void addThing(Thing thing) {
        //check if total weight exceeds limit
        int actualWeight = thing.getWeight() + totalWeight();
        if (actualWeight <= maxWeight) {
            things.add(thing);
        }
    }

    public void printThings() {
        for (Thing row : things) {
            System.out.println(row);
        }
    }

    public int totalWeight() {
        int totalWeight = 0;
        for (Thing row : things) {
            totalWeight += row.getWeight();
        }
        return totalWeight;
    }

    public Thing heaviestThing() {
        
        if (!things.isEmpty()) {
            int i = 0;
            int heaviestIndex = i;
            while (i < things.size()) {
                if (things.get(heaviestIndex).getWeight() < things.get(i).getWeight()) {
                    heaviestIndex = i;
                }
                i++;
            }
            return things.get(heaviestIndex);
            
        } else {
            return null;
        }
    }

    public String toString() {

        int size = things.size();
        String returnString = "";

        if (size == 0) {
            returnString = "empty";
        } else if (size == 1) {
            returnString = size + " thing";
        } else {
            returnString = size + " things";
        }

        returnString += " (" + totalWeight() + " kg)";
        return returnString;
    }
}
