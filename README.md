# Get GPS Coordinates from Photos using PHP!



### This PHP script includes the HTML form for uploading files. When the file is uploaded, the script checks to see if the uploaded file is an image. We then upload the file to the server, and pass the filename to the ```_getGPSMetaData()``` function. We check to see if the file is in the specified path, if our checks return ```true``` then we go ahead and run our ```_getGPSLocation()``` to parse the metadata and spit out the latitude and longitude! 

