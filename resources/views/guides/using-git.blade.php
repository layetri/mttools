@extends('layout')

<title>Using Git | layetri</title>
<link rel="stylesheet" href="{{asset('css/guide.css')}}">

@section('content')
  <div class="w-2/3 mb-10" id="app">
    <h1>Using Git</h1>
    <hr>

    <p>This guide is meant to get you up and running with Git (and in this case GitHub). Git is an easy way to collaborate on code projects and back up your work in an easy, versioned way. This works for all your SysBas/CSD projects, including Max, Teensy and JavaScript.</p>
    <br>

    <h5>Table of Contents</h5>
    <ol>
      <li><a href="#what-youll-need">What you'll need</a></li>
      <li><a href="#installation">Installing GitHub and setting up</a></li>
      <li><a href="#creating-repositories">Creating repositories</a></li>
      <li><a href="#using-github">Using GitHub</a></li>
    </ol>
    <br>

    <h3 id="what-youll-need">What you'll need</h3>
    <ul>
      <li>A GitHub Educational account. GitHub Pro is free for students, we will use the Pro functionality to create private repositories for your code. You can create one <a href="https://education.github.com/pack">here</a> (Get Pack) using your student email address.</li>
      <li>The GitHub Desktop client. This client can be downloaded <a href="https://desktop.github.com/">here</a> and will be used to sync your code with your GitHub repositories.</li>
    </ul>
    <br>

    <h3 id="installation">Installing GitHub and setting up</h3>
    <p>Assuming you've downloaded and installed the GitHub Desktop client, we can now start the software and log in with the GitHub account you've just created. When you've logged in, click on <code>Create a New Repository on your hard drive</code>. You'll be creating new repositories for every project you work on.</p>
    <br>

    <h3 id="creating-repositories">Creating Repositories</h3>
    <p>When you create a repository, you need to name it. This name cannot contain spaces. After naming it, give it a suitable description and choose a location where the repository should be created.</p>

    <b>What is a repository?</b>
    <p>A repository is a folder on your computer that is synced with your online Git repository. This folder contains code and is versioned, meaning that you can roll back changes when something goes wrong. For this, it is important that you sync this repository often! Syncing will be explained in Using GitHub.</p>
    <br>

    <h3 id="using-github">Using GitHub</h3>
    <b>Adding or updating files</b>
    <p>When you've created your repository, you can drop files into the folder to add them. When you do this, the file will appear in your GitHub Desktop client. When you make changes to the file, GitHub will detect these and add the files to the queue as well. Here's how to upload the files:</p>

    <ul>
      <li>Click the checkbox next to the filename.</li>
      <li>Below the files list is a little form. Fill in a suitable version (1.0, 19-mar-2020, etc) and a description for the changes you've made.</li>
      <li>Click on <code>Commit to master</code>.</li>
      <li>If it's your first time adding files to this repository, you'll see a button saying <code>Publish repository</code>. Click this button to push your changes to the remote repository (the GitHub server). After doing this for the first time, make sure to go to <code>https://github.com/YOUR_USERNAME/REPOSITORY_NAME</code>, click <code>Settings</code>, scroll down to the Danger Zone and click on <code>Make Private</code>. This way, your code won't be visible to the world.</li>
      <li>If it isn't your first time adding files, click the button saying <code>Push origin</code>. Your code will now be pushed to the server.</li>
    </ul>
    <br>

    <b>Collaborating on code</b>
    <p>TBA</p>

  </div>
@endsection