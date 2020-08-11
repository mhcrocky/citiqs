How to use Node and NPM without installation or admin rights

 January 8, 2017  Shravan Kumar Kasagoni 
 
There are a lot of blog posts explaining this already, but most of them didn’t work for me. They miss one critical step, in this blog post I am going to provide instructions step by step how to use Node and NPM without installation or admin rights. I am going to provide the instructions for windows; we can follow the same process for other operating systems (macOS, Linux).

Step 1: Get node binary (node.exe) from nodejs.org site

Go to https://nodejs.org/en/download/ site, then from the downloads table download the  32-bit or 64-bit binary/binaries (not installer files) depending on your operating system.
Now copy the file node.exe to your favourite location. In my case, I created a folder named nodejs under the Tools folder in the root of my C drive (C:\Tools\nodejs\).
Step 2: Get the NPM

Go to https://github.com/npm/npm/releases site, then download the latest stable version of NPM. You can find the zip file under downloads section at the bottom of the page.
Extract the zip file and rename the extracted folder to npm.
Now go to C:\Tools\nodejs\ (in your case which ever the folder you copied the node.exe file), create a folder called, node_modules then copy the entire folder npm folder from the previous step the node_modules folder.
Step 3: Copy npm.cmd beside the node.exe

This is the very important step everyone misses, go to C:\Tools\nodejs\node_modules\npm\bin\ folder. Under the bin folder you will find the npm.cmd file.
Copy the npm.cmd file and place it beside the node.exe from step 1. In my case I am copying the npm.cmd file to C:\Tools\nodejs\ folder.
Step 4: Configure the PATH

We need add the node.exe and npm.cmd to system path, so that we can access them from any where.
Now append the path C:\Tools\nodejs; to PATH variable in Environment Variables.
We can access the Environment Variables dialog, by right clicking on the Computer > Properties > Advanced system settings > Advanced tab > Environment Variables.
Incase if you don’t have permission to access Environment Variables dialog, simply type the following command in Run dailog rundll32 sysdm.cpl,EditEnvironmentVariables, this will open the Environment Variables dialog.
Step 5: Verify the nodejs and npm setup

Go to command line then type node -v then npm -v. These commands should display the currently configured nodejs and npm versions respectively.