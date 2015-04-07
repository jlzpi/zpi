package ZPI;

import static org.junit.Assert.*;

import java.util.HashMap;

import org.junit.Assert;
import org.junit.Test;
import org.openqa.selenium.Alert;
import org.openqa.selenium.By;
import org.openqa.selenium.NoAlertPresentException;
import org.openqa.selenium.UnhandledAlertException;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import wtbox.util.WaitTool;
import static org.junit.Assert.*;

import java.util.Calendar;
import java.util.HashMap;
import java.util.List;
import java.util.concurrent.TimeUnit;

import org.junit.Assert;
import org.junit.Test;
import org.openqa.selenium.Alert;
import org.openqa.selenium.By;
import org.openqa.selenium.Dimension;
import org.openqa.selenium.ElementNotVisibleException;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.NoAlertPresentException;
import org.openqa.selenium.NoSuchElementException;
import org.openqa.selenium.Point;
import org.openqa.selenium.UnhandledAlertException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebDriver.Window;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.FluentWait;
import org.openqa.selenium.support.ui.WebDriverWait;

import com.google.common.base.Function;
import com.google.common.base.Predicate;
import com.thoughtworks.selenium.Wait;

import wtbox.util.WaitTool;

public class Test1 {

	FirefoxDriver driver;	
	 WebElement textBoxLogin;
     WebElement textBoxPass;
     
     WebElement buttonLogIn;
	
	public void polaczenieZeStrona() {
		

		if (driver==null) {driver = new FirefoxDriver(); 
		 driver.get("http://localhost/ZPI/frontend/html/login.html");
	      
	        try {
				Thread.sleep(6000);
			} catch (InterruptedException e1) {
				e1.printStackTrace();
			}
		}
		else 
			driver.get("http://localhost/ZPI/frontend/html/login.html");
	      
	}
	
	
	@Test
	public void wyborKategoriiOrazObrazek() {
		polaczenieZeStrona();
		
		String LOGIN="uczen";
		String HASLO="asdf";
	    
       
        
        textBoxLogin=driver.findElement(By.id("test_login"));
        textBoxPass=driver.findElement(By.id("test_haslo"));
        buttonLogIn=driver.findElement(By.id("test_zaloguj"));
        
        assertNotNull(textBoxLogin);
        assertNotNull(textBoxPass);
        assertNotNull(buttonLogIn);
        
        
        textBoxLogin.clear();
        textBoxPass.clear();
		textBoxLogin.sendKeys(LOGIN);
    	textBoxPass.sendKeys(HASLO);
    	

    	//try {
    	buttonLogIn.click();
    	//System.out.println(ExpectedConditions.alertIsPresent());
    	
    	Exception ex=null;
    	
    	try {
    		Alert a=driver.switchTo().alert();//.accept();

    	}
    	
    	catch(NoAlertPresentException e) {
    		ex=e;
    	}
    
        assertNotNull(ex);
        
        WaitTool.waitForJQueryProcessing(driver, 10);
        
        WebElement list;
	    WebElement buttonChoose;
	    list=driver.findElement(By.xpath("//select[@id='list']"));
	    buttonChoose=driver.findElement(By.xpath("//button[@id='choose']"));
	    assertNotNull(list);
	    assertNotNull(buttonChoose);
		
	    //WebElement select = driver.findElement(By.name("select"));
	    List<WebElement> options = list.findElements(By.tagName("option"));
	    assertNotNull(options);
	    assertNotEquals(options.size(),0);
	    options.get(0).click();
	    
	    
	    
	    ex=null;
	    try {
	    	buttonChoose.click();
	    }
	    catch (ElementNotVisibleException e) {
	    	ex=e;
	    }
	    assertNull(ex);
	    
	   WebElement question= driver.findElement(By.id("question"));
	   WebElement picture= driver.findElement(By.id("picture"));
	   
	   assertNotNull(question);
	   assertNotNull(picture);
	   
	   
	   
	    
	}
	
	
	@Test
	public void logowaniePrawidlowe() {//(expected=IndexOutOfBoundsException.class
	
				polaczenieZeStrona();
		
		    
		        WebElement buttonLogOut;
		        
		        
		        
		        HashMap<String,String> poprawne=new HashMap<>();
		        poprawne.put("uczen", "asdf");
		        poprawne.put("nauczyciel", "asdf");
		      
			    for (String key: poprawne.keySet()){
			    	    textBoxLogin=driver.findElement(By.id("test_login"));
				        textBoxPass=driver.findElement(By.id("test_haslo"));
				        buttonLogIn=driver.findElement(By.id("test_zaloguj"));
			    	
				        assertNotNull(textBoxLogin);
				        assertNotNull(textBoxPass);
				        assertNotNull(buttonLogIn);
				        
				        
				        textBoxLogin.clear();
				        textBoxPass.clear();
			    		textBoxLogin.sendKeys(key);
			        	textBoxPass.sendKeys(poprawne.get(key));
			        	
			        	buttonLogIn.click();
			        	
			        	Exception ex=null;
			        	
			        	try {
			        		Alert a=driver.switchTo().alert();//.accept();
			
			        	}
			        	
			        	catch(NoAlertPresentException e) {
			        		ex=e;
			        	}
			        
			        	assertNotNull(ex);
			        	
								        	
								        	
			        	try{
							//jakiœ bzdetny alert WebDriver wywala, to tylko po to ten accept.
							polaczenieZeStrona();
							driver.switchTo().alert().accept();
							
						}
			        	catch(NoAlertPresentException e) {}
			        	catch(UnhandledAlertException e){}
								        

			        
			        	WaitTool.waitForJQueryProcessing(driver, 20);

			        	WebElement userSpan=driver.findElement(By.xpath("//span[@id='user']"));//userSpan;

			        	buttonLogOut=driver.findElement(By.id("logoutButton"));
			        	assertNotNull(userSpan);
			        	assertNotNull(buttonLogOut);
			        	System.out.println(userSpan.getText());
			        	assertEquals(userSpan.getText(),key); 	
			        	
			        	buttonLogOut.click();
			        	ex=null;	
			        	
			    	    try{    
			    	        WebDriverWait wait=new WebDriverWait(driver,2);
			    	        wait.until(ExpectedConditions.alertIsPresent());
			    	        Alert alert=driver.switchTo().alert();
			    	        alert.accept();
			    	        
			        	}
			        	catch(Exception e) {
			        		ex=e;
			        	}
			        	assertNull(ex);
			        	
			  
			    }  
	}
	
	
	
	
	@Test
	public void logowanieNieprawidlowe() {
	
				polaczenieZeStrona();
		        
		        HashMap<String,String> niepoprawne=new HashMap<>();
		        niepoprawne.put("uczen", "");
		        niepoprawne.put("nauczyciel", "dasdf");
		        niepoprawne.put("", "asdf");
		      
			    for (String key: niepoprawne.keySet()){
			    	    textBoxLogin=driver.findElement(By.id("test_login"));
				        textBoxPass=driver.findElement(By.id("test_haslo"));
				        buttonLogIn=driver.findElement(By.id("test_zaloguj"));
			    	
				        assertNotNull(textBoxLogin);
				        assertNotNull(textBoxPass);
				        assertNotNull(buttonLogIn);
				        
				        
				        textBoxLogin.clear();
				        textBoxPass.clear();
			    		textBoxLogin.sendKeys(key);
			        	textBoxPass.sendKeys(niepoprawne.get(key));
			        	

			        	buttonLogIn.click();
			        
			        	Exception ex=null;
			        	
			        	try {
			        		Alert a=driver.switchTo().alert();
			        		a.accept();
			
			        	}
			        	
			        	catch(NoAlertPresentException e) {
			        		ex=e;
			        	}
			        
			        	assertNull(ex);
			        	
			        
			    }  
	}
	
	

}
