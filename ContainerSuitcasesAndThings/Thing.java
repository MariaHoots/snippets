/**
 *
 * @author maria
 */
public class Thing {
    private String name = "";
    private int weight = 0;
    
    public Thing(String name, int weight) {
        this.name = name;
        this.weight = weight;
    }
    
    public String getName() {
        return this.name;
    }
    
    public int getWeight() {
        return this.weight;
    }

    public String toString() {
        return this.name + " (weight " + this.weight + "kg)";
    }
    
}
