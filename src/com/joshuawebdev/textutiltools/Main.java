package com.joshuawebdev.textutiltools;

public class Main {
    public static void main(String[] args) {

        Csv2Array csv2Array = new Csv2Array();

        csv2Array.setFileName("Example.csv");

        System.out.println(csv2Array.getFileName());
        
    }
}
