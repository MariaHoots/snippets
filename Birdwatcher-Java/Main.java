
import java.util.ArrayList;
import java.util.Scanner;

public class Main {

    public static void main(String[] args) {
        // implement your program here
        // do not put all to one method/class but rather design a proper structure to your program
        Scanner reader = new Scanner(System.in);
        
        BirdWatcher BirdWatcher = new BirdWatcher();

        // Your program should use only one Scanner object, i.e., it is allowed to call 
        // new Scanner only once. If you need scanner in multiple places, you can pass it as parameter
        while (true) {
            System.out.print("? ");
            String command = reader.nextLine();
            
            if (command.equals("Quit")) {
                break;
            }
            
            if (command.equals("Add")) {
                System.out.print("Name: ");
                String name = reader.nextLine();
                System.out.print("Latin Name: ");
                String latinName = reader.nextLine();
                //add new Bird Object to the list
                BirdWatcher.addBird(new Bird(name, latinName));
            }
            
            if (command.equals("Observation")) {
                System.out.print("What was observed:? ");
                String name = reader.nextLine();
                //check if bird is in
                Bird result = BirdWatcher.getBird(name);
                if (result != null) {
                    result.addObservation();
                } else {
                    System.out.println("Is not a bird!");
                }
            }
            
            if (command.equals("Show")) {
                System.out.print("What? ");
                String name = reader.nextLine();
                Bird result = BirdWatcher.getBird(name);
                if (result != null) {
                    System.out.println(result);
                } else {
                    System.out.println("Is not a bird!");
                }
            }
            
            if (command.equals("Statistics")) {
                BirdWatcher.printBirds();
            }

        }

    }

}
