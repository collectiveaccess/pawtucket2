/* ----------------------------------------------------------------------
 * js/ca/ca.audiorecorder.js
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2025 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */ 

var caUI = caUI || {};

caUI.initAudioRecorder = function (options) {
	var that = jQuery.extend({
		// Used for media recorder
		mediaRecorder: null,
		audioChunks: [],
		isPaused: false,
		audioBlob: null,
		mimeType: null,
		stream: null,

		// Used for audio visualization
		audioContext: null,
		analyser: null,
		dataArray: null,
		source: null,
		animationFrame: null,

		vnId: null,   // Object ID to be set manually
		saveUrl: null, // Save endpoint URL

		// IDs for UI Elements (defaults)
		startBtnId: "startBtn",
		pauseBtnId: "pauseBtn",
		stopBtnId: "stopBtn",
		downloadBtnId: "downloadBtn",
		audioPlaybackId: "audioPlayback",
		postRecordingContainerId: "postRecordingContainer",
		audioNameId: "audioName",
		audioNotesId: "audioNotes",
		visualizerId: "visualizer",
		cancelBtnId: "cancelBtn",
		saveBtnId: "saveBtn",
		successMessageId: "successMessage",
		errorMessageId: "errorMessage"

	}, options);

	// Assign UI elements
	that.startBtn = document.getElementById(that.startBtnId);
	that.pauseBtn = document.getElementById(that.pauseBtnId);
	that.stopBtn = document.getElementById(that.stopBtnId);
	that.downloadBtn = document.getElementById(that.downloadBtnId);
	that.audioPlayback = document.getElementById(that.audioPlaybackId);
	that.postRecordingContainer = document.getElementById(that.postRecordingContainerId);
	that.audioName = document.getElementById(that.audioNameId);
	that.audioNotes = document.getElementById(that.audioNotesId);
	that.visualizer = document.getElementById(that.visualizerId);
	that.canvasContext = that.visualizer.getContext("2d");
	that.cancelBtn = document.getElementById(that.cancelBtnId);
	that.saveBtn = document.getElementById(that.saveBtnId);
	that.successMessage = document.getElementById(that.successMessageId);
	that.errorMessage = document.getElementById(that.errorMessageId);

	// Ensure elements exist
	if (!that.startBtn) console.error("Missing Start Button ID: " + that.startBtnId);

	if (!that.vnId) console.error("Missing vnId: Set it when initializing.");
	if (!that.saveUrl) console.error("Missing saveUrl: Set it when initializing.");

	// Start Recording
	that.startRecording = async function () {
		try {
			that.stream = await navigator.mediaDevices.getUserMedia({ audio: true });

			that.audioContext = new AudioContext();
			that.analyser = that.audioContext.createAnalyser();
			that.source = that.audioContext.createMediaStreamSource(that.stream);
			that.source.connect(that.analyser);
			that.analyser.fftSize = 256;
			that.dataArray = new Uint8Array(that.analyser.frequencyBinCount);
			that.drawVisualizer();

			// Show visualizer
			that.visualizer.classList.remove("hidden");

			// Select supported MIME type
			that.mimeType = MediaRecorder.isTypeSupported("audio/mp4") ? "audio/mp4" : "audio/webm";
			console.log("Using MIME type:", that.mimeType);

			that.mediaRecorder = new MediaRecorder(that.stream, { mimeType: that.mimeType });

			that.mediaRecorder.ondataavailable = event => that.audioChunks.push(event.data);

			that.mediaRecorder.onstop = () => that.processRecording();

			that.mediaRecorder.start();
			that.isPaused = false;

			// UI Updates
			that.startBtn.disabled = true;
			that.pauseBtn.disabled = false;
			that.stopBtn.disabled = false;
			that.downloadBtn.classList.add("hidden");
			that.postRecordingContainer.classList.add("hidden");

		} catch (err) {
			console.error("Error starting recording:", err);
		}
	};

	// Pause/Resume Recording
	that.togglePauseRecording = function () {
		if (!that.mediaRecorder) return;
		if (that.isPaused) {
			that.mediaRecorder.resume();
			that.pauseBtn.innerHTML = "<span class='glyphicon glyphicon-pause'></span> Pause";
			that.drawVisualizer();
		} else {
			that.mediaRecorder.pause();
			that.pauseBtn.innerHTML = "<span class='glyphicon glyphicon-play'></span> Resume";
			cancelAnimationFrame(that.animationFrame);
		}
		that.isPaused = !that.isPaused;
	};

	// Stop Recording
	that.stopRecording = function () {
		if (that.mediaRecorder) {
			that.mediaRecorder.stop();
			cancelAnimationFrame(that.animationFrame);
			that.startBtn.disabled = true;
			that.pauseBtn.disabled = true;
			that.stopBtn.disabled = true;
		}
	};

	// Process Recording
	that.processRecording = function () {
		that.audioBlob = new Blob(that.audioChunks, { type: that.mimeType });
		const audioUrl = URL.createObjectURL(that.audioBlob);
		that.audioPlayback.src = audioUrl;

		// Download Button
		that.downloadBtn.classList.remove("hidden");
		that.downloadBtn.href = audioUrl;
		that.downloadBtn.download = `recording.${that.mimeType.split("/")[1]}`;
		that.downloadBtn.onclick = () => {
			const a = document.createElement("a");
			a.href = audioUrl;
			a.download = that.downloadBtn.download;
			a.click();
		};

		that.visualizer.classList.add("hidden");
		that.postRecordingContainer.classList.remove("hidden");
		that.audioChunks = [];
	};

	// Cancel Recording
	that.cancelRecording = function () {
		if (that.mediaRecorder && that.mediaRecorder.state !== "inactive") {
			that.mediaRecorder.stop();
		}

		// Reset
		that.audioChunks = [];
		that.audioPlayback.src = "";
		that.startBtn.disabled = false;
		that.pauseBtn.disabled = true;
		that.stopBtn.disabled = true;
		that.downloadBtn.classList.add("hidden");
		that.audioName.value = "";
		that.audioNotes.value = "";
		that.postRecordingContainer.classList.add("hidden");

		// Clear Visualizer
		that.visualizer.classList.add("hidden");
		cancelAnimationFrame(that.animationFrame);
		that.animationFrame = null;
		that.canvasContext.clearRect(0, 0, that.visualizer.width, that.visualizer.height);
	};

	// Draw Visualizer
	that.drawVisualizer = function () {
		that.animationFrame = requestAnimationFrame(that.drawVisualizer);
		that.canvasContext.fillStyle = "lightgrey";
		that.canvasContext.fillRect(0, 0, that.visualizer.width, that.visualizer.height);
		that.analyser.getByteFrequencyData(that.dataArray);
		that.canvasContext.fillStyle = "darkgrey";
		for (let i = 0; i < that.dataArray.length; i++) {
			let barHeight = that.dataArray[i] / 2;
			that.canvasContext.fillRect(i * 3, that.visualizer.height - barHeight, 2, barHeight);
		}
	};

	// Submit File
	that.submitFile = function () {
		try {
			if (!that.audioBlob || that.audioBlob.size === 0) {
				alert("No audio recorded!");
				return;
			}

			const formData = new FormData();
			formData.append("audio", that.audioBlob, `recording.${that.mimeType.split("/")[1]}`);
			formData.append("id", that.vnId); // Manually set when initializing
			formData.append("download", "1");
			formData.append("name", that.audioName.value.trim());
			formData.append("notes", that.audioNotes.value.trim());

			console.log("Submitting FormData:", Object.fromEntries(formData.entries()));

			$.ajax({
				url: that.saveUrl, // Passed during initialization
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				success: function (response) {
					console.log("Upload response:", response);

					// Parse concatenated JSON responses
					if (typeof response === "string") {
						try {
							response = JSON.parse("[" + response.replace(/}{/g, "},{") + "]");
							response = response.pop(); // Take last valid object
						} catch {
							return showError("Invalid server response.");
						}
					}

					// Check for errors in response
					if (response.status === "error" || (response.errors && response.errors.length)) {
						return showError(response.message, response.errors);
					}

					// Show success message
					that.successMessage.classList.remove("hidden");
					setTimeout(() => that.successMessage.classList.add("hidden"), 3000);
					that.cancelRecording();
				},
				error: function (xhr) {
					showError("Upload Error!", [xhr.responseText]);
				}
			});
		} catch (error) {
			showError("Unexpected Error!", [error.message]);
		}

		// Helper function to show error messages
		function showError(message, errors = []) {
			console.error(message, errors);
			that.errorMessage.classList.remove("hidden");
			let errorText = errors.length ? errors.join("<br>") : "";
			that.errorMessage.innerHTML = `<strong>${message}</strong><br>${errorText}`;
			setTimeout(() => that.errorMessage.classList.add("hidden"), 6000);
		}
	};

	// Attach event listeners
	that.startBtn.addEventListener("click", that.startRecording);
	that.pauseBtn.addEventListener("click", that.togglePauseRecording);
	that.stopBtn.addEventListener("click", that.stopRecording);
	that.cancelBtn.addEventListener("click", that.cancelRecording);
	that.saveBtn.addEventListener("click", that.submitFile);

	return that;
};