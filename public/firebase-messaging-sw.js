// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyDF9iMmmotYt2u5RXEv8suvzR0F-SSwdos",
    authDomain: "pizzahot-652b8.firebaseapp.com",
    projectId: "pizzahot-652b8",
    storageBucket: "pizzahot-652b8.appspot.com",
    messagingSenderId: "77744327643",
    appId: "1:77744327643:web:cc801560621bc43e3f35fe",
    measurementId: "G-KG9WEV042Y"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
