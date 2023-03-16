import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Scanner;

public class Auto {
    public static void main(String[] args) throws IOException {
            File folder = new File(".\\Flo");
            File[] files = folder.listFiles();
            for (File file : files) {
                Scanner reader = new Scanner(file);
                String data = "";
                while (reader.hasNextLine()) {
                    data += reader.nextLine();
                    data += "\n";
                }
                data = data.replace("$server=\"127.0.0.1:3306\";\n$username=\"root\";\n$password=\"\";\n$database = \"infits\";", "require \"connect.php\";"); 
                FileWriter myWriter = new FileWriter(file);
                // System.out.println(data);
                myWriter.write(data);
                myWriter.close();
                System.out.println(file.getName());
            }
    }
}