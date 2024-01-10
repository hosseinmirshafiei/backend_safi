import './bootstrap';
let MessagesBox = document.getElementById("Messages");

// const channel = Echo.channel('my-channel-name');
// channel
//     .subscribed(() => {
//         console.log("subscribed");
//     })
//     .listen(".CHM" , (event)=>{
//         console.log(event)
//     });

const channel = Echo.private("channel-name.38");
channel
    // .subscribed(() => {
    //     console.log("subscribed");
    // })
    .listen(".CHM", (event) => {
        console.log(event);
    });

