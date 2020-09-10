@extends('layout')

<title>Using IDEA | mttools</title>
<link rel="stylesheet" href="{{asset('css/guide.css')}}">

@section('content')
  <div class="w-2/3 mb-10">
    <h1>Using Racket/Scheme in IntelliJ IDEA</h1>
    <hr>
    <h5>Introduction</h5>
    <p>This document aims at providing a comprehensive guide to get the Scheme language up and running within the IntelliJ IDEA IDE from JetBrains. Note: This guide assumes you have already installed Racket on your system.</p><br>

    <h5>Table of Contents</h5>
    <ol>
      <li><a href="#links">Links</a></li>
      <li><a href="#installation">Installation</a></li>
      <li><a href="#preference-tweaking">Preference Tweaking</a></li>
      <li><a href="#concluding">Concluding</a></li>
    </ol><br>

    <h3 id="links">Links</h3>
    <b>Necessary</b>
    <ul>
      <li><a href="">IntelliJ IDEA</a> can be purchased from JetBrains. They offer free student licenses after verification by student e-mail.</li>
      <li><a href="">This Scheme syntax plugin</a> can be downloaded for free.</li>
    </ul>
    <b>Nice to have</b>
    <ul>
      <li><a href="">Material Theme for IntelliJ IDEA</a>. Installing themes is beyond the scope of this guide, please refer to the IDEA documentation.</li>
    </ul>
    <br>

    <h3 id="installation">Installation</h3>
    <b>Installing IDEA</b>
    <p>The installation process for IntelliJ IDEA is fairly simple. Drag the file to your applications folder and wait until this is done. Then open the program. At first launch, you'll be asked a bunch of questions to set up your preferences (dark or light theme, installation of extra plugins). In most cases, you can leave these settings at their default. When you finish the installation, you'll be presented with a default screen for opening projects and doing a bunch of other stuff.</p><br>

    <b>Installing Scheme language support</b>
    <p>It's now time to install the Scheme plugin. Here's the basic steps:</p>

    <ul>
      <li>First, extract the zip file you downloaded</li>
      <li>Then, in the default IDEA project-opening screen, click on "Configure" and browse to "Plugins"</li>
      <li>Select the gear icon in the top bar, then click "Load plugin from disk"</li>
      <li>Browse to where you extracted your zip file, then navigate to schemely > lib and open the file schemely.jar. This will install the plugin.</li>
      <li>Then click on "Restart IDE" to restart IDEA</li>
    </ul>
    <br>

    <h3 id="preference-tweaking">Preference Tweaking</h3>
    <b>Creating a working directory for Scheme exercises</b>
    <p>This is a step for HKU students: because it's kinda useful to keep all your work in one place, I recommend you to create a new project in IDEA and storing all your Scheme stuff in it. Note that this folder name must not contain spaces in order for Racket to work.</p>
    <br>


    <b>Setting up IDEA to use Bash (Windows only)</b>
    <p>Because IDEA on Windows uses the native cmd.exe, which doesn't support our Racket installation, we need to set it to use Ubuntu Bash. Here's how to do it:</p>

    <ul>
      <li>Open <code>Settings > Tools > Terminal</code></li>
      <li>Find the Shell Path and change it to <code>bash.exe</code></li>
      <li>Now IDEA will use Bash as the default terminal, allowing you to execute your Racket files.</li>
    </ul>
    <br>

    <b>Creating a run configuration for Racket</b>
    <p>When you've created your new project, it's time to add some useful shortcuts for Racket.</p>

    <ul>
      <li>Open <code>Settings > Tools > External Tools</code></li>
      <li>Click the "+" icon at the bottom of the window</li>
      <li>Give the Tool an appropriate name and description (like "Racket" and "This tool runs the current file using the Racket script.")</li>
      <li>For "Program", click the folder icon and browse to <code>Applications > Racket vX.X > bin</code> and select the file called racket</li>
      <li>For "Arguments", click "Insert Macro", select "FilePath" and click "OK"</li>
      <li>Then click "OK" to create the Tool</li>
    </ul>
    <br>
    <p>Next, we add a keyboard shortcut to run the current file.</p>
    <ul>
      <li>First, restart IDEA completely (in macOS, this means closing every instance of the app and reopening it from the Launchpad). Then reopen your project.</li>
      <li>Open Settings > Keymap</li>
      <li>Unfold (click ">") <code>External Tools > External Tools</code>. You'll see the Tool you just created</li>
      <li>Right-click that Tool and select "Add keyboard shortcut". Press the keys you want to use as a shortcut (I recommend using <code>cmd + shift + R</code>. Click "remove" in the popup that appears when setting this shortcut).</li>
      <li>Click "OK" to save your keyboard shortcut</li>
    </ul>
    <p>This shortcut now works throughout IDEA, both inside and outside the context of the current project.</p>
    <br>

    <b>Creating a file template for Scheme files</b>
    <p>It's time to create a template for Racket files.</p>

    <ul>
      <li>Click "Project" in the top bar of the file tree and select "Project Files" to see all files in your project. Because IDEA is a Java editor, it won't show Scheme files when "Project" is selected.</li>
      <li>Right click on the project folder and go to New > Edit File Templates</li>
      <li>Click the "+" icon in the top bar</li>
      <li>Name your template something like "Scheme File"</li>
      <li>Set the file extension to .rkt</li>
      <li>Below that, paste the following code. This will appear in every Scheme file you create and includes all the required files to export LilyPond code:
      <pre class="my-4 py-3">
        <code>#lang racket

          (require csd/lilypond)
          (require csd/music_transforms)</code></pre></li>
      <li>Click "OK" to save your template</li>
    </ul>
    <br>

    <p>Now, to create a new Scheme file, you right-click the project directory and select New > Scheme File. After putting in a name, this will create a .rkt file with all the prerequisites for exporting LilyPond code. IMPORTANT NOTE: because IDEA doesn't natively support Scheme, it'll try to create this file by Java standards. Doing this, it puts a space between #l and ang racket on the first line. Remove this space first before executing your code, as it will cause an error in Racket.</p>
    <br>

    <h3 id="concluding">Concluding</h3>
    <p>You can now do the following in IDEA:</p>

    <ul>
      <li>Create new Scheme files via "Project Folder" > right-click > New > Scheme File</li>
      <li>Run your Scheme file within IDEA using your custom keyboard shortcut</li>
    </ul>
    <br>
    <p>IDEA also:</p>

    <ul>
      <li>automatically puts double brackets, so you don't accidentally miss one</li>
      <li>color-codes your Scheme code, so you can instantly see if an expression is incomplete</li>
    </ul>
  </div>
@endsection