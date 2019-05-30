import cv2
import numpy as np
import time

cap=cv2.VideoCapture(1)
#fgbg = cv2.bgsegm.createBackgroundSubtractorMOG()
moto=0
car=0
truck=0

for x in range(0, 50, 1): 
	_, frame = cap.read()

while(cap.isOpened()):
	
	_, frame = cap.read()
	#fgmask = fgbg.apply(frame)
	
	gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
	ret,thresh = cv2.threshold(gray,127,255,0) 
    
	contours, hierarchy = cv2.findContours(thresh,cv2.RETR_TREE,cv2.CHAIN_APPROX_NONE)
	
	for c in contours:
		rect = cv2.minAreaRect(c)
		box = cv2.boxPoints(rect)
		box = np.int0(box)
		w = rect[1][0]
		h = rect[1][1]
		
		if w*h>1600:
			cv2.drawContours(frame,[box],0,(0,0,255),2)
			if w*h<4000:
				moto=moto+1
			elif w*h<8800:
				car=car+1
			else:
				truck=truck+1
				
	print("moto" , moto)
	print("car" , car)
	print("truck" , truck)
	print("-------------")
	#print(len(contours))
	
	moto=0
	car=0
	truck=0

	cv2.imshow("frame", frame)
	key = cv2.waitKey(1) & 0xFF
	if key == ord("q"):
		break
	
cap.release()
cv2.destroyAllWindows()
		

