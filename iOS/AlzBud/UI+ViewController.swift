//
//  UI+ViewController.swift
//  alexa-simulator
//
//  Created by Alex Cuello ortiz on 01/04/2017.
//  Copyright © 2017 Eironeia. All rights reserved.
//

import UIKit

//extension ViewController {
//    
//    func setUI(status: SpeechStatus) {
//        switch status {
//        case .ready:
//            microphoneButton.setImage(#imageLiteral(resourceName: "MicIcon"), for: .normal)
//        case .recognizing:
//            microphoneButton.setImage(#imageLiteral(resourceName: "StopIcon"), for: .normal)
//        case .unavailable:
//            microphoneButton.setImage(#imageLiteral(resourceName: "StopIcon"), for: .normal)
//        }
//    }
//    
//}


//enum SpeechStatus {
//    case ready
//    case recognizing
//    case unavailable
//}
//
//class ViewController: UIViewController {
//    
//    @IBOutlet weak var microphoneButton: UIButton!
//    @IBOutlet weak var flightTextView: UITextView!
//    
//    let synth = AVSpeechSynthesizer()
//    var myUtterance = AVSpeechUtterance(string: "")
//    
//    var status = SpeechStatus.ready {
//        didSet {
//            self.setUI(status: status)
//        }
//    }
//    
//    let audioEngine = AVAudioEngine()
//    let speechRecognizer: SFSpeechRecognizer? = SFSpeechRecognizer()
//    let request = SFSpeechAudioBufferRecognitionRequest()
//    var recognitionTask: SFSpeechRecognitionTask?
//    
//    override func viewDidLoad() {
//        super.viewDidLoad()
//        
//        switch SFSpeechRecognizer.authorizationStatus() {
//        case .notDetermined:
//            askSpeechPermission()
//        case .authorized:
//            self.status = .ready
//        case .denied, .restricted:
//            self.status = .unavailable
//        }
//        
//    }
//    
//    /// Ask permission to the user to access their speech data.
//    func askSpeechPermission() {
//        SFSpeechRecognizer.requestAuthorization { status in
//            OperationQueue.main.addOperation {
//                switch status {
//                case .authorized:
//                    self.status = .ready
//                default:
//                    self.status = .unavailable
//                }
//            }
//        }
//    }
//    
//    /// Start streaming the microphone data to the speech recognizer to recognize it live.
//    func startRecording() {
//        // Setup audio engine and speech recognizer
//        guard let node = audioEngine.inputNode else { return }
//        let recordingFormat = node.outputFormat(forBus: 0)
//        node.installTap(onBus: 0, bufferSize: 1024, format: recordingFormat) { buffer, _ in
//            self.request.append(buffer)
//        }
//        
//        // Prepare and start recording
//        audioEngine.prepare()
//        do {
//            try audioEngine.start()
//            self.status = .recognizing
//        } catch {
//            print("Error hai")
//            return print(error)
//        }
//        
//        // Analyze the speech
//        recognitionTask = speechRecognizer?.recognitionTask(with: request, resultHandler: { result, error in
//            if let result = result {
//                self.flightTextView.text = result.bestTranscription.formattedString
//                print("Now perform action with text: \(self.flightTextView.text)")    // self.searchFlight(number: result.bestTranscription.formattedString)
//            } else if let error = error {
//                print(error)
//            }
//        })
//    }
//    
//    func tenRecord() {
//        
//        SFSpeechRecognizer.requestAuthorization { authStatus in
//            if authStatus == SFSpeechRecognizerAuthorizationStatus.authorized {
//                if let path = Bundle.main.url(forResource: "test", withExtension: "m4a") {
//                    //.main.urlForResource("test", withExtension: "m4a") {
//                    let recognizer = SFSpeechRecognizer()
//                    let request = SFSpeechURLRecognitionRequest(url: path)
//                    recognizer?.recognitionTask(with: request, resultHandler: { (result, error) in
//                        if let error = error {
//                            print("There was an error: \(error)")
//                        } else {
//                            print(result?.bestTranscription.formattedString ?? "Default")
//                            self.flightTextView.text = "\(String(describing: result?.bestTranscription.formattedString))"
//                        }
//                    })
//                }
//            }
//        }
//        
//    }
//    
//    /// Stops and cancels the speech recognition.
//    func cancelRecording() {
//        audioEngine.stop()
//        if let node = audioEngine.inputNode {
//            node.removeTap(onBus: 0)
//        }
//        recognitionTask?.cancel()
//    }
//    
//    @IBAction func microphonePressed() {
//        switch status {
//        case .ready:
//            tenRecord()
//            status = .recognizing
//        case .recognizing:
//            cancelRecording()
//            status = .ready
//        default:
//            break
//        }
//    }
//}
