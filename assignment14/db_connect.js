const MongoClient = require('mongodb').MongoClient;
const uri = "mongodb+srv://temp:helloWorld@cluster0.apc42.mongodb.net/myFirstDatabase?retryWrites=true&w=majority";

// async function clientConnect() {
//     // connect to your cluster
//     const client = await MongoClient.connect(uri, {
//         useNewUrlParser: true,
//         useUnifiedTopology: true,
//     });

//     // specify the DB's name
//     const db = client.db('comp20');

//     // execute find query
//     const items = await db.collection('mbti_questionnaire').find({}).toArray();

//     // console.log(items);
//     client.close();
//     return items;
// };

// module.exports = new Promise(function (resolve, reject) {
//     (async () => {
//         var data = await clientConnect();
//         resolve(data);
//     })()
// });

// const client = MongoClient.connect(uri, {
//     useNewUrlParser: true,
//     useUnifiedTopology: true,
// });

// const datab = client.db('comp20');
// const col = datab.collection('mbti_questionnaire');
// var data_stream = col.find().stream();
// data_stream.on('data', function(item) {
//     console.log(item.question);
// });

// data_stream.on('end', function() {
//     console.log("end of data");
//     db.close();
// });

MongoClient.connect(uri, { useUnifiedTopology: true }, function(err, db) {
    if(err) { console.log("Connection err: " + err); return; }
  
    var dbo = db.db("comp20");
	var coll = dbo.collection('mbti_questionnaire');
	
	console.log("before find");
	var s = coll.find().stream();
	s.on("datda", function(item) {console.log("Data "+ item.question)});
	s.on("end", function() {console.log("end of data"); db.close();});
	console.log("after close");
});  //end connect
