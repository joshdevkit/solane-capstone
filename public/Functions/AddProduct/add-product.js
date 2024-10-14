// Import Firestore functions from the Firebase CDN
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.23.0/firebase-app.js";
import { getFirestore, collection, addDoc } from "https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore.js";

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyC93dtof5hhdhm-3k9Gp8rkkZA3Em7eHX0",
    authDomain: "gufcs-28cb0.firebaseapp.com",
    databaseURL: "https://gufcs-28cb0-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "gufcs-28cb0",
    storageBucket: "gufcs-28cb0.appspot.com",
    messagingSenderId: "563013105555",
    appId: "1:563013105555:web:cdea7bbd2f5a9453041a66",
    measurementId: "G-T70GM9R1EB"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Initialize Firestore
const db = getFirestore(app);

// Add a product
document.querySelector('form').addEventListener('submit', async (event) => {
    event.preventDefault();

    // Collect form data
    const productName = document.getElementById('productName').value;
    const productCode = document.getElementById('productCode').value;
    const barcodeSymbology = document.getElementById('barcodeSymbology').value;
    const category = document.getElementById('category').value;
    const cost = document.getElementById('cost').value;
    const price = document.getElementById('price').value;
    const quantity = document.getElementById('quantity').value;
    const description = document.getElementById('description').value;

    try {
        // Add a new document with the form data to Firestore
        const docRef = await addDoc(collection(db, 'products'), {
            productName,
            productCode,
            barcodeSymbology,
            category,
            cost,
            price,
            quantity,
            description
        });
        console.log('Product added with ID: ', docRef.id);
        alert('Product added successfully!');
    } catch (error) {
        console.error('Error adding document: ', error);
        alert('Failed to add product.');
    }
});
