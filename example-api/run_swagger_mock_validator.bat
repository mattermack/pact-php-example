@echo off
echo "+++++++++++++ Running mackanalyticapconsumerphp-analyticapi.json"
start swagger-mock-validator .\src\swagger.json D:\Temp\pact-examples\exampleonemeetupapiclient-meetupapi.json

echo "+++++++++++++ Running mackanalyticapconsumer-analyticapi.json"
start swagger-mock-validator  .\src\swagger.json D:\Temp\pact-examples\exampletwomeetupapiclient-meetupapi.json