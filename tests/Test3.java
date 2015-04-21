package ZPI;

import static org.junit.Assert.*;


import org.junit.Test;
import org.openqa.selenium.Alert;
import org.openqa.selenium.By;
import org.openqa.selenium.NoAlertPresentException;
import org.openqa.selenium.WebElement;

import wtbox.util.WaitTool;

import java.util.List;
import org.openqa.selenium.ElementNotVisibleException;
import org.openqa.selenium.chrome.ChromeDriver;



public class Test3 {

	ChromeDriver driver;	
	 WebElement textBoxLogin;
     WebElement textBoxPass;
     
     WebElement buttonLogIn;
	
	public void polaczenieZeStrona() {
		

		System.setProperty("webdriver.chrome.driver", "chromedriver.exe");
		if (driver==null) {driver = new ChromeDriver(); 
		 driver.get("http://localhost/ZPI/frontend/html/login.html");
	      
	        try {
				Thread.sleep(6000);
			} catch (InterruptedException e1) {
				e1.printStackTrace();
			}
		}
		else 
			driver.get("http://localhost/ZPI/frontend/html/login.html");
	 
		logowanie();
	}
	
	
	public void logowanie(){
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
        
       
		
	    //WebElement select = driver.findElement(By.name("select"));
	    
	}
	
	public void wyborKategorii(){
		 WebElement list;
		   WebElement buttonChoose;
		   list=driver.findElement(By.xpath("//select[@id='list']"));
		   buttonChoose=driver.findElement(By.xpath("//button[@id='choose']"));
		   assertNotNull(list);
		   assertNotNull(buttonChoose);
		   List<WebElement> options = list.findElements(By.tagName("option"));
		    assertNotNull(options);
		    assertNotEquals(options.size(),0);
		    options.get(0).click();
		    
		    
		    
		    Exception ex=null;
		    try {
		    	buttonChoose.click();
		    }
		    catch (ElementNotVisibleException e) {
		    	ex=e;
		    }
		    assertNull(ex);
	}
	
	@Test
	public void nawigowaniePoObrazkach() {
		polaczenieZeStrona();
		wyborKategorii();
		
	    
	   WebElement next= driver.findElement(By.id("next"));
	   WebElement previous= driver.findElement(By.id("previous"));
	   
	   assertNotNull(next);
	   assertNotNull(previous);
	   
	   

	   WebElement question= driver.findElement(By.id("question"));
	   WebElement picture= driver.findElement(By.id("picture"));
	   
	   assertNotNull(question);
	   assertNotNull(picture);
	  
	   WaitTool.waitForJQueryProcessing(driver, 10);
       
	   
	   String s1=question.getText();
	  
	   Exception e=null;
	   try{
		   next.click();
	   }
	   catch (ElementNotVisibleException exc) {
		   e=exc;
	   }
	   
	   assertNull(e);
	   
	   question= driver.findElement(By.id("question"));
	   picture= driver.findElement(By.id("picture"));
	   
	   assertNotNull(question);
	   assertNotNull(picture);
	   
	   String s2=question.getText();
	   assertNotEquals(s1, s2);
	   
	   
	   previous= driver.findElement(By.id("previous"));


	   e=null;
	   try{
		   previous.click();
	   }
	   catch (ElementNotVisibleException exc) {
		   e=exc;
	   }
	   
	   assertNull(e);
	   
	   WaitTool.waitForJQueryProcessing(driver, 10);
       
	   
	   question= driver.findElement(By.id("question"));
	   picture= driver.findElement(By.id("picture"));
	   
	   assertNotNull(question);
	   assertNotNull(picture);
	   
	   String s3=question.getText();
	   assertNotEquals(s3, s2);
	   assertEquals(s1, s3);
	   
	   
	   //next= driver.findElement(By.id("next"));
	   //next.click();
	   
	  
	}
	
	
	

	@Test
	public void opisPrzezMikrofon() {
		polaczenieZeStrona();
		wyborKategorii();
		
		 WebElement mic= driver.findElement(By.id("toggleMic"));


		 WaitTool.waitForJQueryProcessing(driver, 10);
		 
		 Exception e=null;
		   try{
			   mic.click();
		   }
		   catch (ElementNotVisibleException exc) {
			   e=exc;
		   }
		   
		   assertNull(e);
		 
		   
		   //TODO: HTTPS:// instead of HTTP:// <- not necessary to handle popup
		   /*e=null;
	       	
	       	try {
	       		Alert a=driver.switchTo().alert(); 
	       		a.accept();
	
	       	}
	       	
	       	catch(NoAlertPresentException ex) {
	       		e=ex;
	       	}
	       
	       	assertNull(e);*/

	       	WebElement textBox=driver.findElement(By.id("textarea"));
	       	boolean dis=Boolean.parseBoolean(textBox.getAttribute("disabled"));
	       	System.out.println(dis);
	       	assertTrue(dis);
	       	
	       	mic= driver.findElement(By.id("toggleMic"));
	       	
	        e=null;
			try{
				   mic.click();
			}
			catch (ElementNotVisibleException exc) {
			   e=exc;
			}
			   
			assertNull(e);
	       	
			textBox=driver.findElement(By.id("textarea"));
	       	dis=Boolean.parseBoolean(textBox.getAttribute("disabled"));
	       	assertFalse(dis);
	}
	
	@Test
	public void ocena() {
		polaczenieZeStrona();
		wyborKategorii();

		 WebElement send= driver.findElement(By.id("send"));


		 WaitTool.waitForJQueryProcessing(driver, 10);
		 
		 Exception e=null;
		   try{
			   send.click();
		   }
		   catch (ElementNotVisibleException exc) {
			   e=exc;
		   }
		   
		   assertNull(e);
		   
		   WaitTool.waitForJQueryProcessing(driver, 10);
		   

		   WebElement answer= driver.findElement(By.id("answer"));

		   
		   assertNotNull(answer);
		   
		   String empty="";
		   //System.out.println("/"+answer.getText()+"/");
		   assertNotEquals(answer.getText(), empty);
		
	}
	
	@Test
	public void wyborTestu() {
		polaczenieZeStrona();
		WebElement test=driver.findElement(By.id("test"));
		
		assertNotNull(test);
		
		Exception e=null;
		try{
		   test.click();
		}
		catch (ElementNotVisibleException exc) {
		   e=exc;
		}
		   
		assertNull(e);
		   
		WebElement question= driver.findElement(By.id("question"));
		WebElement picture= driver.findElement(By.id("picture"));
		WebElement next= driver.findElement(By.id("next"));
		  
		
		assertNotNull(question);
		assertNotNull(picture);
		assertNotNull(next);
		
		
		
	}
	
	

}
