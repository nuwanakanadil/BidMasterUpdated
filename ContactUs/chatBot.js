let confirmation= false;
let conf = false;
let base;
const qrUrls = [
    'http://www.linkedin.com/in/nuwanaka-nadil-9145442a5',
    'https://www.linkedin.com/in/sithum-ridmal-2a19802a7?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app',
    'https://www.linkedin.com/in/deneth-koralage-8154b4319/',
    'https://www.linkedin.com/in/amod-indupa-739a74293?fromQR=1',
    'https://www.linkedin.com/in/isara-nethmina-44b988319?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app'
]; /* this list of links replace with your QR code URLs */


document.getElementById('chat-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        let userInput = this.value; /* In this case "this.value" is used to get the value of the input field.
        this.value is a JS Model that help to store the current value of somewhere */
        if (userInput) {
            addMessage(userInput, 'user-message');
            this.value = ''; //clean the input field after sending the message

            setTimeout(() => {
                let botResponse = getBotResponse(userInput);
                addMessage(botResponse, 'bot-message');
            }, 1000);/* setTimeout is a JS inbuilt function that use to set 
            a timer for a time to delay the execution of a function*/
        }
    }
});//The user types messages and then when user presses enter button 

function addMessage(text, className) {
    let chatContainer = document.getElementById('chat-container');
    let messageElement = document.createElement('div');
    messageElement.className = 'message ' + className;
    messageElement.innerText = text;
    chatContainer.appendChild(messageElement);
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

function getBotResponse(input) {
    let response = '';

    if (conf) {
        if (input.toLowerCase() === 'yes' && base === 2) {
            response = `If you click on the "Categories" button you can see the categories of the products.
                If you click on "Shop" button you can see the products. If you click on "Contact us" button you can contact us.
                If you click on "About us" button you can see the about us page.`;
            waitingForConf = false;
            
        } else if ((input.toLowerCase() === 'Continue' || input.toLowerCase() === 'continue') && base === 2) {
            response = `No problem! If you need more assistance, feel free to contact us through our website or social media platforms.`;
            waitingForConf = false;
            conf=false;
        } else {
            response = `Please respond with "Yes" or "continue".`; 
        }
    }

    else if (confirmation/* this is for the confirmation, which is checking the value that has been passed by the below condition is true */) {
        if (input.toLowerCase() === 'yes' && base === 2) {
            response = `Yes, It's very'simple. when you login to our system first of all you can see the home page and the top of that page you can see a navigation bar. 
            On that it is displayed some buttons call "Home","Categories", "Shop", "Contact us" and "About us". Those buttons will giude you to discover our services. If you need more detailed information about the functionalities of that button send me "yes" or you can continue the chat by saying "Continue".`;
            waitingForConfirmation = false; 
            conf=true;
        } else if (input.toLowerCase() === 'no' && base === 2) {
            response = `No problem! If you need more assistance, feel free to contact us through our website or social media platforms.`;
            waitingForConfirmation = false;
            conf=false;
            confirmation =false;
        }
        else if((input.toLowerCase() === 'yes'||input.toLowerCase() === 'Yes'||input.toLowerCase() === 'yes please'||input.toLowerCase() === 'Yes please'
        ||input.toLowerCase() === 'ok'||input.toLowerCase() === 'Ok'||input.toLowerCase() === 'ok'||input.toLowerCase() === 'Okay'
        ||input.toLowerCase() === 'okay') && base === 3){

            generateQRCode();
            response = `Here's your QR code of your assistent, Scan it to contact him`;
            confirmation = false;
            
        } else {
            response = `Please respond with "Yes" or "No".`; 
        }
    }
    else {
        if (input.toLowerCase().includes('hello') || input.toLowerCase().includes('hey') || input.toLowerCase().includes('hi')) {
            response = `Hi there! I'm your personal assistant, built to answer your quick questions.\n
            1. Trust and Security Concerns\n2. Complex Navigation\n3. Bid Management Uncertainty\n4. Payment and Shipping Worries`;
        } 

        else if (input.toLowerCase().includes('help') || input.toLowerCase().includes('need help') || input.toLowerCase().includes('i need help') 
        || input.toLowerCase().includes('i need assistance') || input.toLowerCase().includes('i want help') || input.toLowerCase().includes('help me')) {
            response = `Sure, I'm here to help! What do you need assistance with?`;
        }

        else if (input.toLowerCase().includes('1')||input.toLowerCase().includes('I need to know about security concerns')||input.toLowerCase().includes('i need to know about security')
        ||input.toLowerCase().includes('i want to know about security')||input.toLowerCase().includes('I want to know about security')||input.toLowerCase().includes('I need to know about security')
        ||input.toLowerCase().includes('Security concerns')||input.toLowerCase().includes('security')||input.toLowerCase().includes('trust')
        ||input.toLowerCase().includes('Trust')||input.toLowerCase().includes('Trust and Security Concerns')||input.toLowerCase().includes('trust and security concerns')
        ||input.toLowerCase().includes('i need to know about security concerns')||input.toLowerCase().includes('i want to know security concerns')
        ||input.toLowerCase().includes('I want to know about security concerns')||input.toLowerCase().includes('I need a proper idea about security concerns')
        ||input.toLowerCase().includes('i need a proper idea about security concerns')||input.toLowerCase().includes('I need a proper idea about security concerns')
        ||input.toLowerCase().includes('What are the potential security risks')||input.toLowerCase().includes('what are the potential security risks')
        ||input.toLowerCase().includes('Can you explain the security issues')||input.toLowerCase().includes('can you explain the security issues')
        ||input.toLowerCase().includes('How secure is the system')||input.toLowerCase().includes('how secure is the system')
        ||input.toLowerCase().includes('Are there any vulnerabilities I should be aware of')||input.toLowerCase().includes('are there any vulnerabilities i should be aware of')
        ||input.toLowerCase().includes('What security measures are in place')||input.toLowerCase().includes('what security measures are in place'))
        {
            response = `Our platform prioritizes your security. We have a dedicated team of cybersecurity experts who work around the clock to safeguard your data and transactions.
                We implement multiple layers of advanced security protocols, such as encryption, firewalls, and regular system audits, to ensure that your bidding experience is safe, secure, and worry-free.
                This means that your personal information and bidding activities are protected against unauthorized access, providing you with a secure environment to participate in auctions with confidence.`;
        }

        else if (input.toLowerCase().includes('I wanna know about the security measures')||input.toLowerCase().includes('i wanna know about the security measures')
        ||input.toLowerCase().includes('i want to know about the security measures')||input.toLowerCase().includes('I want to know about the security measures')||input.toLowerCase().includes('I need to know about the security measures')
        ||input.toLowerCase().includes('i need to know about the security measures')||input.toLowerCase().includes('I need to know about security measures')
        ||input.toLowerCase().includes('I need to know about security of your system')||input.toLowerCase().includes('i need to know about security of your system')
        ||input.toLowerCase().includes('I want to know about security of your system')||input.toLowerCase().includes('i want to know about security of your system')){
            response = `Our platform prioritizes your security. We have a dedicated team of cybersecurity experts who work around the clock to safeguard your data and transactions.
                We implement multiple layers of advanced security protocols, such as encryption, firewalls, and regular system audits, to ensure that your bidding experience is safe, secure, and worry-free.
                This means that your personal information and bidding activities are protected against unauthorized access, providing you with a secure environment to participate in auctions with confidence.`;
        }

        else if (input.toLowerCase().includes('2')||input.toLowerCase().includes('Complex Navigation')||input.toLowerCase().includes('complex')||input.toLowerCase().includes('Complex')||input.toLowerCase().includes('complex navigation')
        ||input.toLowerCase().includes('the navigation is so complex')||input.toLowerCase().includes('the navigation is too complex')||input.toLowerCase().includes('The navigation is too complex')
        ||input.toLowerCase().includes('The navigation is so complex')||input.toLowerCase().includes('the navigation is so complex')||input.toLowerCase().includes('The navigation is confusing')||input.toLowerCase().includes('the navigation is confusing')
        ||input.toLowerCase().includes(`the navigations are too comples`)||input.toLowerCase().includes('The navigations are too complex')
        ||input.toLowerCase().includes('The navigations are so complex')||input.toLowerCase().includes('the navogations are so complex')||input.toLowerCase().includes('i can not understand the navigations')||input.toLowerCase().includes('I can not understand the navigations')
        ||input.toLowerCase().includes('i can\'t understand the navigations')||input.toLowerCase().includes('I can\'t understand the navigations')||input.toLowerCase().includes('i can not understand the navigations')||input.toLowerCase().includes('I can not understand the navigations')
        ||input.toLowerCase().includes('i need to get an idea about navigations')||input.toLowerCase().includes('I need to get an idea about navigation')
        ) {

            response = `Dear customer, we are sorry if you found our navigation uncomfortable. 
            We've designed our website to be more responsive, user-friendly, and effective. If you need more details, send me "Yes" or "No". 
            Or you can go to the contact page and click on "Agent chat" for more assistance.`;
            confirmation = true; // set a logical value to run down the next step
            base = 2;

        }

        else if (input.toLowerCase().includes('3')||input.toLowerCase().includes('i need a proper idea about bidding')||input.toLowerCase().includes('I need a proper idea about bidding')
        ||input.toLowerCase().includes('i want a proper idea about bidding')||input.toLowerCase().includes('I want a proper idea about bidding')
        ||input.toLowerCase().includes('i need a proper idea about bids')||input.toLowerCase().includes('I need a proper idea about bids')||input.toLowerCase().includes('i want a proper idea about bids')
        ||input.toLowerCase().includes('I want a proper idea about bids')||input.toLowerCase().includes('i need a proper idea about payment')||input.toLowerCase().includes('I need a proper idea about payment')
        ||input.toLowerCase().includes('i want a bidding assistance')||input.toLowerCase().includes('I want a bidding assistance')||input.toLowerCase().includes('i need a bidding assistance')||input.toLowerCase().includes('I need a bidding assistance')
        ||input.toLowerCase().includes('i want a payment assistance')||input.toLowerCase().includes('I want a payment assistance')||input.toLowerCase().includes('i need a payment assistance')||input.toLowerCase().includes('I need a payment assistance')
        ||input.toLowerCase().includes('Bid management uncertainty')||input.toLowerCase().includes('Bid management uncertainty')){

            response = `Dear customer, we understand that managing bids can be challenging. Our platform offers tools to help you monitor and adjust bids easily. 
            Normally we display every item and their information for bidding. If you need personal and professional agent support, we can connect you with a professional. 
            If you need a profetional suport let me know.`;
            confirmation = true;
            base = 3;

        }

        else if (input.toLowerCase().includes('4')||input.toLowerCase().includes('i need a proper idea about payment')||input.toLowerCase().includes('I need a proper idea about payment')
        ||input.toLowerCase().includes('i want a proper idea about payment')||input.toLowerCase().includes('I want a proper idea about payment')
        ||input.toLowerCase().includes('i need a proper idea about payment gateway')||input.toLowerCase().includes('I need a proper idea about payment gateway')){
            response = `Dear customer, we provide you with an online payment gateway with high-security protocols. 
            You also have the full ability to negotiate with sellers to get a better idea of how to complete payment after the auction process is over.`;
        }

        else if (input.toLowerCase().includes('thank you')||input.toLowerCase().includes('Thank you')||input.toLowerCase().includes('thanks')||input.toLowerCase().includes('Thanks')) {
            response = `We are happy to help. Have a nice day!`;
        }

        else {
            response = `Could you please, just say "Hi"`;
        }

    return response;

    }

    return response;
}

function generateQRCode() {
    const canvas = document.getElementById('qr-code');
    const qr = new QRious({
        element: canvas,
        size: 250,
        value: qrUrls[Math.floor(Math.random() * qrUrls.length)] // Select a random QR URL
    });
    openModal();
}

function openModal() {
    document.getElementById('qrModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('qrModal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == document.getElementById('qrModal')) {
        closeModal();
    }
}