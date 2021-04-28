const MongoClient = require('mongodb').MongoClient;
const uri = "mongodb+srv://temp:helloWorld@cluster0.apc42.mongodb.net/myFirstDatabase?retryWrites=true&w=majority";
// const data_array = [];

// MongoClient.connect(uri, { useUnifiedTopology: true }, function (err, db) {
//     if (err) { console.log("Connection err: " + err); return; }

//     var dbo = db.db("comp20");
//     var coll = dbo.collection('mbti_questionnaire');

//     var s = coll.find().stream();
//     s.on("data", function (item) {
//         // console.log("Data " + item.question);
//         data_array.push(item.question);
//     });
//     s.on("end", function () {
//         db.close();
//         console.log(data_array);
//     });
// });

async function clientConnect() {
    const client = await MongoClient.connect(uri, {
        useNewUrlParser: true,
        useUnifiedTopology: true,
    });
    const db = client.db('comp20');
    const items = await db.collection('mbti_questionnaire').find({}).toArray();
    client.close();
    return items;
};

(async () => {
    var data = await clientConnect();
    console.log(data);
})()